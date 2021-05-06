@extends('admin.home')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Đơn vị tính</h6>
        <a href="#" class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#categoryModal">Thêm mới</a>
    </div>
    <div class="result">
        @if(Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
    </div>

    <div class="result">
        @if(Session::get('fail'))
        <div class="alert alert-danger">
            {{ Session::get('fail') }}
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên ĐVT</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Ngày Cập nhật</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Tên Danh Mục</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Ngày Cập nhật</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $stt = 1 ?>
                    @foreach($units as $key => $unit)
                    <tr>
                        <td>{{ $stt }}</td>
                        <td>{{ $unit->category_name }}</td>
                        <td>{{ $unit->status }}</td>
                        <td>{{ $unit->created_at }}</td>
                        <td>{{ $unit->updated_at }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-info btn-circle" onclick="editCategory({{$unit->id}})" data-toggle="modal" data-target="#categoryEditModal">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-circle">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $stt++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm mới danh mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="categoryname">Tên danh mục</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" />
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa danh mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryEditForm" action="{{route('category.update')}}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" />
                    <div class="form-group">
                        <label for="categoryname">Tên danh mục</label>
                        <input type="text" class="form-control" id="category_name_edit" name="category_name_edit" />
                    </div>
                    <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


<script>
    function editCategory(id) {
        $.get("category-show/" + id, function(category) {
            $("#id").val(category.id);
            $("#category_name_edit").val(category.category_name);
            $("#categoryEditModal").modal("toggle");
        });
    }
</script>
@endsection