<script src="https://gitcdn.xyz/cdn/Laralum/Advertisements/7174d5940d4789431b9e27227999bc449a815eb1/src/Assets/ads.js" type="text/javascript"></script>
<script src="https://gitcdn.xyz/cdn/vincepare/iframeTracker-jquery/56960ccf4bc600754348832e7e5fdc092e562d35/jquery.iframetracker.js" type="text/javascript"></script>
@yield('blocker-code')
<script>
    jQuery(document).ready(function($){
        $('.laralum-advertisement iframe').iframeTracker({
            blurCallback: function(){
                var url = "{{ route('laralum_public::advertisements.click', ['advertisement' => '']) }}/" + this._overId;
                $.post( url , {'_token': "{{ csrf_token() }}"});
            },
            overCallback: function(element){
                this._overId = $(element).parents('.laralum-advertisement').attr('id');
            },
            outCallback: function(element){
                this._overId = null;
            },
            _overId: null
        });
    });
</script>
