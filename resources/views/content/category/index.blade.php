@extends('layouts/contentNavbarLayout')
@section('page-script')
    <script src="{{ asset('assets/js/delete-item.js') }}"></script>
@endsection


@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Tables /</span> Basic Tables
</h4>

<hr class="my-5">

<!-- Hoverable Table rows -->
<div class="card">
  {{-- <h5 class="card-header">Hoverable rows</h5> --}}
  <div class="row  m-3" >
    <div class="d-flex justify-content-between">
      <div></div>

        <a href="{{ route('category_create') }}"  class="btn btn-primary">Ստեղծել</a>

    </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>N</th>
          <th>Լոգո</th>
          <th>Կատեգորիաներ</th>


          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($categories as $category )
        <tr>
          <td>{{ ++$i }} </td>
          <td><img src ="{{ route('get-file',['path'=>$category->path])  }}" style="height:50px;width:50px"></td>
          <td>{{ $category->translation('am')->name }}</td>
          <td>
            <div class="dropdown action" data-id="{{ $category->id }}" data-tb-name="categories">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('category_edit',$category->id) }}"><i class="bx bx-edit-alt me-1"></i> Խմբագրել</a>
                <a class="dropdown-item" href="{{ route('category_subcategory_edit',$category->id) }}"><i class="bx bx-edit-alt me-1"></i> Կատեգորիա Սուբկատեգորիա</a>
                <a class="dropdown-item click_delete_item" href="javascript:void(0);"
                    data-bs-toggle="modal" data-bs-target="#smallModal"

                ><i class="bx bx-trash me-1"></i>Ջնջել</a>
              </div>
            </div>
          </td>
        </tr>

        @endforeach


      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-end m-2">
    {{ $categories->links() }}
  </div>
</div>
<!--/ Hoverable Table rows -->


<!--/ Responsive Table -->
<x-modal-delete></x-modal-delete>
@endsection
