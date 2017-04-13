@extends('laralum_advertisements::scripts.layout')
@section('blocker-code')
<script type="text/javascript">
    if(!document.getElementById('bGaTAfOwltCE')){
        window.location.replace("{{ Laralum\Advertisements\Models\Settings::first()->content }}");
    }
</script>
@endsection
