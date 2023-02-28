@extends('template')
@section('content')

<section>
    <div class="section-box">
        <p></p>
    </div>
    <div class="form-box">
        <div class="textarea-box">
            <form method="GET" action="#">
                <textarea name="textarea" id="" cols="30" rows="10"></textarea>
                <button v-on:click="buttonClicked"><i class="bi bi-send" style="font-size: 30px"></i></button>
            </form>
        </div>
    </div>
</section>

@endsection