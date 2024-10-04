var user_saved_properties = $("#user_saved_properties").val();

if (typeof user_saved_properties != "undefined") {
    if (user_saved_properties.length != 0) {
        var array = $.parseJSON(user_saved_properties);
        $(".savedProperty").each(function (key, value) {
            property_id = $(value).attr("id");
            if ($.inArray(parseInt(property_id), array) !== -1) {
                $(".icon_" + property_id).css("color", "#1E1D85");
            } else {
                $(".icon_" + property_id).css("color", "grey");
            }
        });
    }
}

$(".savedProperty").on("click", function (e) {
    var property_id = $(this).attr("id");
    $(".savedPropertyForm_" + property_id).each(function (i, obj) {
        if (i == $(".savedPropertyForm_" + property_id).length - 1) {
            savedPropertyForm(property_id, obj);
            $(obj).submit();
        }
    });
    e.preventDefault();
});

function savedPropertyForm(id, obj) {
    $(obj)
        .off("submit")
        .on("submit", function (e) {
            e.preventDefault();
            var form = $(this);
            var formUrl = form.attr("action");
            var type = form.attr("data-action_type");

            $.ajax({
                type: "POST",
                url: formUrl,
                data: $(this).serialize(),
                success: function (data) {
                    if (data.length !== 0) {
                        toastr.success(data.data.display_text);
                        if (data.data.in_saved) {
                            $(".icon_" + id).css("color", "#1E1D85");
                        } else {
                            $(".icon_" + id).css("color", "grey");
                        }

                        if (type == "delete") {
                            location.reload();
                        }
                    }
                },
                error: function (request) {
                    console.log(request.statusText);
                },
            });
        });
}

$(".sortby").change(function (e) {
    $("#sortByForm").submit();
    e.preventDefault();
});

$(document).ready(function (e) {
    queryUrl = window.location.href;

    $array = queryUrl.toString().split("?");
    $.each($array, function (id, value) {
        $url = value;
    });
});

$("#sortByForm").on("submit", function (e) {
    e.preventDefault();
    var formUrl = $(this).attr("action");
    var searchInput = $("#searchInput").val();
    var selectedOptionVal = $(this).find(":selected").val();

    search_append_key = "?search=";
    select_append_key = "?sortby=";

    if (searchInput.indexOf(" ") >= 0) {
        searchInput = searchInput.replace(/\s/g, "+");
    }

    if (selectedOptionVal == "none") {
        $array = formUrl.toString().split("?");
        $.each($array, function (id, value) {
            $url = value;
        });
        // console.log($url);
        window.location.href = $url;
    }

    if (searchInput.length != 0 && selectedOptionVal.length != 0) {
        queryUrl =
            formUrl +
            search_append_key +
            searchInput +
            "&sortby=" +
            selectedOptionVal;
    } else if (searchInput.length == 0 && selectedOptionVal.length != 0) {
        queryUrl = formUrl + select_append_key + selectedOptionVal;
    } else if (searchInput.length != 0 && selectedOptionVal.length == 0) {
        queryUrl = formUrl + search_append_key + searchInput;
    }

    window.location.href = queryUrl;
});
