<!----- Footer Contents ----->
<script src="{{ $web_assets }}/vendors/jquery.min.js"></script>
<script src="{{ $web_assets }}/vendors/jquery-ui/jquery-ui.min.js"></script>
<script src="{{ $web_assets }}/vendors/bootstrap/bootstrap.bundle.js"></script>
<script src="{{ $web_assets }}/vendors/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="{{ $web_assets }}/vendors/slick/slick.min.js"></script>
<script src="{{ $web_assets }}/vendors/waypoints/jquery.waypoints.min.js"></script>
<script src="{{ $web_assets }}/vendors/counter/countUp.js"></script>
<script src="{{ $web_assets }}/vendors/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="{{ $web_assets }}/vendors/chartjs/Chart.min.js"></script>
<script src="{{ $web_assets }}/vendors/dropzone/js/dropzone.min.js"></script>
<script src="{{ $web_assets }}/vendors/timepicker/bootstrap-timepicker.min.js"></script>
<script src="{{ $web_assets }}/vendors/hc-sticky/hc-sticky.min.js"></script>
<script src="{{ $web_assets }}/vendors/jparallax/TweenMax.min.js"></script>
<script src="{{ $web_assets }}/vendors/mapbox-gl/mapbox-gl.js"></script>
<script src="{{ $web_assets }}/vendors/dataTables/jquery.dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ $web_assets }}/js/theme.js"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
    $(".property_main_img").on("click", function() {
        const url = $(this).attr("data-url");
        window.location.href = url;
    });

     function copyToClipboard(value) {
            navigator.clipboard.writeText(value)
                .then(() => {
                    toastr.success("Copied to clipboard!")
                })
                .catch((error) => {
                    toastr.error("Failed to copy")
                });
        }

        $(".copy").on("click", function() {
            const value = $(this).attr("data-content");
            if (value) {
                return copyToClipboard(value);
            }
        })
</script>
@yield('script')
