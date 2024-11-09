@extends('admin.layouts.master')

@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Category</div>
            </div>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Categories</h4>
                    <div class="card-header-action">
                        <a href="{{route('admin.category.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
                    </div>
                  </div>
                  <div class="card-body">
                    {{ $dataTable->table() }}
                  </div>

                </div>
              </div>
            </div>

          </div>
        </section>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    {{-- ajax script forenabling and disablign category from data table --}}

    <script>
        $(document).ready(function(){
            $('body').on('click', '.change-status', function(){

                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.category.change-status') }}",
                    method: 'PUT',
                    data: {
                        id: id,
                        status: isChecked,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        if(response.status){
                            toastr.success(response.message);
                        }else{
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error){
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
