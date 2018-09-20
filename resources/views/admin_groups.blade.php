@extends('layouts.app')

@section('title', '个人中心')

@section('link')
@endsection

@section('content')
<div class="row">
    @include('inc.card-center')
    <section class="col-lg-10 d-lg-block right">
        <div class="card">

            <!-- 新建板块区域 -->
            <div class="card-header d-flex justify-content-between">
                <div>
                    <a href="/" class="text-right" data-toggle="modal" data-target="#new-user-group-form-modal">+ 新建用户组</a>
                    <!-- Modal -->
                    <div class="modal fade" id="new-user-group-form-modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">新建用户组</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="new-user-group-form" action="{{ route('userGroup.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="用户组名称" required>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" id="new-user-group-submit-button">新建</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="/" class="text-danger" data-toggle="modal" data-target="#delete-user-group-form-modal">- 删除用户组</a>
                    <!-- Modal -->
                    <div class="modal fade" id="delete-user-group-form-modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">删除用户组</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="delete-user-group-form" action="{{ route('userGroup.destroy') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="form-group">
                                            @foreach($userGroups as $userGroup)
                                            <input type="checkbox" name="groups[]" value="{{ $userGroup->id }}">{{ $userGroup->name }}&emsp;
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                        <button type="button" class="btn btn-danger" id="delete-user-group-submit-button">删除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="accordion w-100" id="accordionGroup">
                    @foreach($userGroups as $userGroup)
                        <div class="card">

                            <!-- 用户组名展示区 -->
                            <div class="card-header text-center" id="group{{ $userGroup->id }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $userGroup->id }}" aria-controls="collapse{{ $userGroup->id }}">
                                    {{ $userGroup->name }}
                                    </button>
                                </h5>
                            </div>

                            <!-- 用户组内容展示区 -->
                            <div id="collapse{{ $userGroup->id }}" class="collapse" aria-labelledby="userGroup{{ $userGroup->id }}" data-parent="#accordionGroup">                           
                                <div class="card-body">

                                    <div class="group-insde-item">
                                        <!-- 一行开始 -->
                                        <div class="d-flex justify-content-between">
                                            <!-- 一行左边 -->
                                            <div>
                                                用户：
                                                @foreach($userGroup->users as $user)
                                                <a href="/">{{ $user->name }}</a>
                                                @endforeach
                                            </div>
                                            <!-- 一行右边 -->
                                            <a href="/" class="ml-3" style="width:15%" data-toggle="modal" data-target="#add-group-user-form-modal-{{ $userGroup->id }}">+ 添加/移除用户</a>
                                        
                                            <!-- Modal -->
                                            <div class="modal fade" id="add-group-user-form-modal-{{ $userGroup->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $userGroup->name }}：添加/移除用户</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="add-group-user-form" action="{{ route('userGroup.addUser') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="user_group_id" value="{{ $userGroup->id }}">
                                                                <div class="text-danger"><strong>删除：</strong>
                                                                @foreach($userGroup->users as $user)
                                                                    <!-- 已加入用户 -->
                                                                    <input type="checkbox" name="del_users[]" value="{{ $user->id }}"> {{ $user->name }} &emsp;
                                                                @endforeach
                                                                </div>
                                                                <hr>
                                                                <div class="text-success"><strong>添加：</strong>
                                                                @foreach($userGroup->notJoinYetUsersId as $user_id)
                                                                    <!-- 获取未加入用户 -->
                                                                    @php $user = App\User::find($user_id) @endphp
                                                                    <input type="checkbox" name="add_users[]" value="{{ $user->id }}"> {{ $user->name }} &emsp;
                                                                @endforeach
                                                                </div>
                                                                <hr>
                                                                <button type="submit" class="btn btn-block btn-primary">执行</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- 一行结束 -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
const deleteUserGroupSubmitButton = $('#delete-user-group-submit-button')
deleteUserGroupSubmitButton.on('click', function(){
    if(confirm('确定删除所选用户组吗？')){
        $(this).parents('form').submit()
    }
})
</script>
@endsection