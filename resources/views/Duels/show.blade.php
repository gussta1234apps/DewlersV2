@extends('layouts.app')

@section('extra_links')

    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>

    @endsection

@section('content')

    <div class="container">
        <div class="row text-center">
            <div class="col-md-6 offset-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ route('posts.post') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="container-fliud">
                                    <div class="wrapper row text-center">
                                        <div class="preview col-md-12">
                                            <div class="preview-pic tab-content">
                                                <br>
                                                <div class="tab-pane active" id="pic-1"><img src="https://gamepedia.cursecdn.com/paladins_esports_gamepedia_en/c/ca/Puleule_VP.png?version=890ac8944d5bac58e3a9f1899e2ea73e"/></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="details col-md-12">
                                            <h3 class="product-title">Witness review</h3>
                                            <div class="rating">
                                                <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $post->userAverageRating }}" data-size="xs">
                                                <input type="hidden" name="id" required="" value="{{ $post->id }}">
                                                <br/>
                                                <button class="btn btn-success">Submit Review</button>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#input-id").rating();
    </script>
@endsection
