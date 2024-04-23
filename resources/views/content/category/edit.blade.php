@extends('layouts/contentNavbarLayout')


@section('page-script')
    <script src="{{ asset('assets/js/upload-image.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/admin\news\index.js') }}"></script> --}}
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/project/project.css') }}">
@endsection

@section('content')
{{-- @include('includes.alert') --}}

    <h4 class="py-3 mb-4">
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{route('category_list')}}">Կատեգորիա </a>
              </li>
              <li class="breadcrumb-item active">Խմբագրել</li>
          </ol>
      </nav>
  </h4>
    <div class="card">

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-header">Խմբագրել</h5>
            </div>

        </div>
        <div class="card-body">
          {{-- {{dd($data)}} --}}

            <form action="{{ route('category_update',$data->id) }}" method="POST" enctype="multipart/form-data">
              @method('put')
              @foreach (languages() as $lang)
                <div class="mb-3 row">
                  <label for="name-{{ $lang}}" class="col-md-2 col-form-label">Անվանում {{ $lang }}
                  <span class="required-field text-danger">*</span>
                  </label>
                    <div class="col-md-10">
                        <input class="form-control"
                              placeholder="Անվանումը {{ $lang }}"
                              value="{{ $data->translation($lang)->name ?? old("translate.$lang.name") }}"
                              name="translate[{{ $lang }}][name]"
                              id="name-{{ $lang}}" name="name"
                              />
                    </div>
                    @error("translate.$lang.name")
                        <div class="mb-3 row justify-content-end">
                            <div class="col-sm-10 text-danger fts-14">{{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>

              @endforeach




                <div class="mb-3 row">
                    <label for="photo" class="col-md-2 col-form-label">Կատեգորիաի նկար
                    <span class="required-field text-danger">*</span>
                    </label>

                    <div class="col-md-10">
                        <div class="d-flex flex-wrap align-items-start align-items-sm-center">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Ներբեռնել նկար</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="photo" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" />
                            </label>
                            <div class="uploaded-images-container uploaded-photo-project" id="uploadedImagesContainer">

                              <div class="uploaded-image-div mx-2">
                                  <img src="{{route('get-file', ['path' => $data->path])}}" class="d-block rounded uploaded-image uploaded-photo-project" height=100 width=100 id="uploadedAvatar">

                              </div>

                            </div>

                        </div>
                    </div>
                </div>
                @error('photo')
                    <div class="mb-3 mt-5 row justify-content-end">
                        <div class="col-sm-10 text-danger fts-14">{{ $message }}
                        </div>
                    </div>
                @enderror
                <div class="mt-5 row justify-content-end">
                  <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">Պահպանել</button>
                  </div>
              </div>
        </div>

        </form>
    </div>


    </div>
@endsection
