<div>
{{--    --}}{{-- Stop trying to control. --}}
    <div class="card lg:card-side bordered">
        @foreach($posts as $post)
        <figure>
            <img src="https://picsum.photos/id/1005/400/250">
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{$post -> title}}</h2>
            <p>{{$post -> comtent}}</p>
            <div class="card-actions">
                <button class="btn btn-primary">Get Started</button>
                <button class="btn btn-ghost">More info</button>
            </div>
        </div>
        @endforeach
    </div>
   </div>
