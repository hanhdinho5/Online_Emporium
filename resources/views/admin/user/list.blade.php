@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('no'))
                <div class="alert alert-danger">
                    {{ session('no') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="" class="form-control form-search mr-3" name="keyword"
                            value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/user/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $item)
                                <option value="{{ $k }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Quyền</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->count() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($users as $user)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                                        </td>
                                        <th scope="row">{{ $t }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                {{-- $user->roles là ds các bản ghi mà user đg có trong user_role --}}
                                                <span class="badge badge-warning">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            @canany(['user.edit'])
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i>
                                                </a>
                                            @endcanany
                                            @canany(['user.delete'])
                                                @if ($user->id != Auth::id())
                                                    <a href="{{ route('delete_user', $user->id) }}"
                                                        onclick="return confirm('Bạn có thực sự muốn xoá quản trị này?')"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                            class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            @endcanany
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="bg-white"> Không có người quản trị thoả mãn </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    {{ $users->links() }}
                </form>
            </div>
        </div>
    </div>
@endsection
