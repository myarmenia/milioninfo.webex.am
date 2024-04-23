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

            <div class="row">
              <form method="post" action="{{ route('category_subcategory_store') }}">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">

                        <strong>Name:</strong>
                      {{ $category->translation('am')->name }}
                      <input type="hidden" name="category_id" value="{{ $category->id }}">

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Subcategories:</strong>
                        <br/>

                        @foreach($subcategories as $value)
                             <label>
                              <input type="checkbox" name='subcategories[]' value="{{ $value->id }}" {{ $category->subcategories->contains($value->id) ? 'checked' : '' }}>

                            {{ $value->subCategory_am }}</label>
                        <br/>
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Հաստատել</button>
                </div>
              </form>
            </div>


        </div>



    </div>
@endsection
