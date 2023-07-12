@php $pcat = $common::getParentCatOfSubCat($book_obj->category);@endphp
                @php $pcat_name = Str::title($common::getCatName($pcat));@endphp
                @php $scat_name = Str::title($common::getCatName($book_obj->category));@endphp
                @php $publishers = $book_obj->publishers()->pluck("publishers.name")->toArray();@endphp
                @php $books_available = $util::countProperty($book_obj->sub_books->toArray(),"borrowed","0"); @endphp
                                @php $tags = $book_obj->tags()->pluck("tags.name")->toArray();
                                $trendbooks = \App\Facades\Common::getBooksDetailsForFrontEndPreffSoloCateg();
                                @endphp
  <div class="single-product">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <div class="line-dec"></div>
              <h1>Book Information</h1>
            </div>
          </div>
          <div class="col-md-4">
            <div class="product-slider">
              <div id="slider" class="flexslider">
                
              <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="slides d-flex" style="justify-content: center;width: 100%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                  <li class="flex-active-slide" style="width: 200px; margin-right: 0px; float: left; display: block;">
                  <img alt={{$book_obj->title}} src="{{$book_obj->cover_img()}}" draggable="false">
                  </li>
                  
                  <!-- items mirrored twice, total of 12 -->
                </ul></div><ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1">Previous</a></li><li class="flex-nav-next"></li></ul></div>
              <div id="carousel" class="flexslider">
                
              <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="slides" style="width: 800%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                  <li class="flex-active-slide" style="width: 210px; margin-right: 5px; float: left; display: block;">
                    
                  </li>
                  
                  
                  
                  <!-- items mirrored twice, total of 12 -->
                </ul></div><ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1">Previous</a></li><li class="flex-nav-next"><a class="flex-next" href="#">Next</a></li></ul></div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="right-content">
              <h2>{{isset($book_obj) ? $book_obj->title : "N/A"}}</h2>
               @php $authors = $book_obj->authors()->pluck("authors.name")->toArray();@endphp
                        @if(count($authors))
                            <strong>{{__("common.by")}} - </strong><span class="">
                                @if(count($authors))
                                    @foreach($authors as $author)
                                        <a class="btn-link"
                                           href="{{url("/")."?search=".$author."#books"}}">{{$author}}</a>
                                        @if(!$loop->last) , @endif @endforeach
                                @else -- @endif
                        </span><br>
                        @endif
              @php $publishers = $book_obj->publishers()->pluck("publishers.name")->toArray();@endphp
                                @if(count($publishers))
                                        <strong>{{__("common.publisher")}}
                                            - </strong>
                                        @if(count($publishers))
                                            @foreach($publishers as $publisher)
                                                <a class="btn-link"
                                                   href="{{url("/")."?search=".$publisher."#books"}}">{{$publisher}}</a>
                                                @if(!$loop->last) , @endif @endforeach
                                        @else -- @endif
                                    
                                @endif

              
              <p>{!! $book_obj->desc !!}</p>
              @if($book_obj->isbn_10)
                                    
                                        <strong>{{__("common.isbn_10")}} - </strong><span>{{$book_obj->isbn_10}}</span>
                                    
                                @endif<br>
              @if($book_obj->isbn_13)
                                    
                                        <strong>{{__("common.isbn_13")}} - </strong><span>{{$book_obj->isbn_13}}</span>
                                   
                                @endif<br>















             













              <br>
              <form action="" method="get" class="d-flex" style="justify-content: flex-end;">
                
                
               
              <div class="mt-2 d-flex col-12" style="justify-content: flex-end; flex-direction: column;">

                                <p class="d-inline">
                                    @livewire("partial. -book",["user_id"=>Auth::id(),"book_id"=>$book_obj->id,"book_obj"=>$book_obj
                                    ,"books_available"=>$books_available])
                                </p></div>

                                <div id="viewer" class="row mt-2 preview_container">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="mcoll">
                                            <div class="card card-body">
                                                <div id="viewerCanvas" style="width: 100%; height: 1000px"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
           
                @if($book_obj->category)
                                      <div class="down-content">
                <div class="categories">
                                        <h6>{{__("common.category")}}
                                            </h6><a class="btn-link"
                                                          href="{{url('/').'?pcat='.$pcat
.'&scat='.$book_obj->category}}#books">
                                            <span>{{$scat_name}}</span></a>
                                    </div>
                                @endif
                  
                
                <div class="share">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
  <div class="featured-items">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <div class="line-dec"></div>
              <h1>You may also like</h1>
            </div>
          </div>
          <div class="col-md-12">
            <div class="owl-carousel owl-theme">

            @foreach($trendbooks as $book)
              <a href="{{route("details", ['page_slug' => $common::utf8Slug($book["TITLE"])])}}
                                 ">
                <div class="featured-item">
                  <img style="width:250px;height:300px;" src="{{asset("uploads/".$util::fileChecker(public_path("uploads"),
                                       $book["CIMG"],config("app.BOOK_IMG_NOT_FOUND")))}}" alt="Item 1">
                  <h4>{{ str_limit($book["TITLE"], $limit = 35, $end = '...') }}</h4>
                  
                </div>
              </a>
              @endforeach
              
            </div>
          </div>
        </div>
      </div>
    </div>
