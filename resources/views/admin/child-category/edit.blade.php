@extends('admin.layouts.master')

@section('content')
<!-- Main Content -->
<section class="section">
    <div class="section-header">
        <h1>Sub Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.sub-category.index') }}">Sub Category</a></div>
            <div class="breadcrumb-item">create</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Sub Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.sub-category.update',$subCategory->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="inputState">Category</label>
                                <select id="inputState" class="form-control" name="category">
                                    <option value="">Select</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}" @selected($category->id == $subCategory->category_id)>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $subCategory->name }}">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select id="inputState" class="form-control" name="status">
                                    <option value="1" @selected($subCategory->status === 1)>Active</option>
                                    <option value="0" @selected($subCategory->status === 0)>Inactive</option>
                                </select>
                            </div>
                            <button type="submmit" class="btn btn-primary">Update</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@extends('admin.layouts.master')

@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Sub Category</h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Create Sub Category</h4>

                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.child-category.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="inputState">Category</label>
                            <select id="inputState" class="form-control main-category" name="category">
                              <option value="">Select</option>
                              @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Sub Category</label>
                            <select id="inputState" class="form-control sub-category" name="sub_category">
                              <option value="">Select</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="status">
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submmit" class="btn btn-primary">Create</button>
                    </form>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </section>

@endsection
