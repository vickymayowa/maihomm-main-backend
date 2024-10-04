<?php

namespace App\Http\Controllers;

use App\Constants\PropertyConstants;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertySpecification;
use App\QueryBuilders\General\PropertyQueryBuilder;
use App\Services\Property\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $request["status"] = $request["status"] ?? PropertyConstants::STATUS_AVAILABLE;
        $properties = PropertyQueryBuilder::filterIndex($request)
            ->latest()->get();
        return view("web.pages.properties.index", [
            "properties" => $properties,
            'filterOptions' => PropertyConstants::FILTER_OPTIONS,
            'statusOptions' => PropertyConstants::STATUS_OPTIONS
        ]);
    }

    public function featured(Request $request)
    {
        $properties = PropertyQueryBuilder::filterIndex($request)
            ->latest()->limit(4)->get();
        return view("web.pages.properties.featured", [
            "properties" => $properties,
        ]);
    }

    public function show($property_id)
    {
        $property = Property::with(["files", "specifications", "defaultImage"])->findOrFail($property_id);
        $specifications = PropertySpecification::where("property_id", $property->id)->get();
        $property_files = $property->files;

        $image_files = $this->filterFilesByType($property_files, "image");
        $video_files = $this->filterFilesByType($property_files, "video");
        $document_files = $this->filterFilesByType($property_files, ["pdf", "sheet_document", "word_document"]);

        $category_properties = Property::where('category_id', $property->category_id)
            ->whereNotIn("id", [$property->id])->latest()->limit(12)->get();

        $close_by_properties = collect();
        if (!empty($property->state_id)) {
            $close_by_properties = Property::where("state_id", $property->state_id)->orWhere("country_id", $property->country_id)
                ->whereNotIn("id", [$property->id])->latest()->limit(12)->get();
        }


        $features = $this->filterSpecificationsByGroup($specifications, "features");
        $amenities = $this->filterSpecificationsByGroup($specifications, "amenities");
        $timelines = $this->filterSpecificationsByGroup($specifications, "Timelines");
        $additional_details = $this->filterSpecificationsByGroup($specifications, ["Timelines", "ROI"]);

        $location  = PropertyService::geocodeAddress($property);

        $property->update([
            "total_clicks" => $property->total_clicks + 1,
            "total_views" => $property->total_views + 1,
        ]);

        return view("web.pages.properties.show", [
            "property" => $property,
            "image_files" => $image_files,
            "video_files" => $video_files,
            "document_files" => $document_files,
            "category_properties" => $category_properties,
            "close_by_properties" => $close_by_properties,
            "display_image_data" => $this->imagesToDisplay($property),
            "amenities" => $amenities,
            "features" => $features,
            "timelines" => $timelines,
            "location" => $location,
            "additional_details" => $additional_details,
        ]);
    }

    public function imagesToDisplay($property)
    {
        $property_files_id = $all_property_files_id = [];
        foreach ($property->files as $files) {
            $all_property_files_id[] = $files->id;
        }
        $property_files_id = array_slice($all_property_files_id, 0, 4, true);
        $remaining_images = count($all_property_files_id) - count($property_files_id);

        return [
            "property_files_id" => $property_files_id,
            "remaining_images" => $remaining_images,
        ];
    }
    public function filterSpecificationsByGroup($collections, $group)
    {
        return $collections->filter(function ($specification) use ($group) {
            if (is_array($group)) {
                return !in_array($specification->group, $group);
            } else {
                return $specification->group == $group;
            }
        });
    }

    public function filterFilesByType($collections, $type)
    {
        return $collections->filter(function ($file) use ($type) {
            if (is_array($type)) {
                return in_array($file->type, $type);
            } else {
                return $file->type == $type;
            }
        });
    }
}
