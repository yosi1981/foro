@extends('layouts.main')
<title>{{ site('site-name') }}</title>
@section('description', site('site-description'))
@section('content')

    @include('errors.alert')

    <h1>Welcome to {{ site('site-name') }}!</h1>

        <header class="box box-primary">
            <div class="box-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus
                    non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam
                    repellat.
                </p>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ad, blanditiis consequuntur debitis
                    deserunt eveniet, fuga incidunt ipsa ipsum maxime minima nesciunt numquam odit placeat quas quis
                    repellat reprehenderit similique.
                </p>
                <p>A accusamus atque, deserunt ducimus enim fuga laborum magnam nemo pariatur possimus quae quasi
                    reiciendis repellat rerum sint soluta sunt suscipit. Dolorem enim fugit mollitia quas repellat
                    repellendus tempora, veritatis.
                </p>
                <p>A ab accusamus alias animi dicta dolores ducimus et eveniet exercitationem incidunt ipsa itaque,
                    iusto minima neque non odio officia qui quidem repellat sequi sint soluta sunt unde, ut voluptate.
                </p>
                <p><a href="{{ route('forum.home') }}" class="btn btn-primary btn-large">Visit The Forum!</a>
                </p>
            </div>
        </header>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Features</h3>
            </div>
        </div>

        <div class="row text-center">

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>You can easily create new pages from the admin panel</p>
                        <p>
                            <a href="#" class="btn btn-primary">Cool</a> <a href="#" class="btn btn-default">More
                                Info</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Try It!</a> <a href="#" class="btn btn-default">More
                                Info</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Wonderful</a> <a href="#" class="btn btn-default">More
                                Info</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Lovely</a> <a href="#" class="btn btn-default">More
                                Info</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>


@stop
