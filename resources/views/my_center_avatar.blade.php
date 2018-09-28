@extends('layouts.app')

@section('title', '个人中心')

@section('link')
@endsection

@section('content')
<div class="row">
    @include('inc.card-center')
    <section class="col-lg-10 d-lg-block right">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.center', [$user->id]) }}">基本资料</a>
                </li>
                @if($user->id == Auth::user()->id)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.center.password', [$user->id]) }}">密码</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.center.avatar', [$user->id]) }}">头像</a>
                </li>
                @endif
            </ul>
            </div>
            <div class="card-body">
                <div class="col-lg-6 mx-auto">
                    <div class="form-group text-center">
                        <img id="user-avatar-area" src="{{ asset($user->avatar) }}" class="user-img-1 mb-3">
                        <div id="avatar-upload-loading-icon" style="display:none;">
                            <svg aria-hidden="true" data-prefix="fas" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 516 516" class="svg-inline--fa fa-spinner fa-w-16 fa-spin fa-lg" style="width: 1rem;"><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z" class=""></path></svg>
                            正在上传
                        </div>
                    </div>
                    <div class="form-group custom-file">
                        <input type="file" name="avatar" class="custom-file-input" accept="image/gif,image/jpeg,image/png,image/jpg,image/bmp" id="avatar-upload-input" value="{{ $user->avatar }}" required>
                        <label class="custom-file-label" for="avatar-upload-input">选择图片</label>
                        @if (session('success'))
                        <div class="invalid-feedback">{{ session('success') }}</div>
                        @elseif(session('fail'))
                        <div class="invalid-feedback">{{ session('fail') }}</div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
const userAvatarArea = $('#user-avatar-area')
const avatarUploadInput = $('#avatar-upload-input')
const avatarUploadLoadingIcon = $('#avatar-upload-loading-icon')

avatarUploadInput.on('change', function(){
    avatarUploadLoadingIcon.show()
    let form = new FormData();
    let avatar = $(this)[0].files[0]
    form.append('user_id', {{ $user->id }})
    form.append('avatar', avatar)
    $.ajax({
        url: '{{ route('user.center.avatar.set', [$user->id]) }}',
        method: 'post',
        data: form,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        cache: false,
        processData: false,
        contentType: false,
        success: function (resp) {
            avatarUploadLoadingIcon.hide()
            if(resp != 'fail'){
                userAvatarArea.attr('src', resp)
            } else {
                avatarUploadLoadingIcon.hide()
                alert('上传出错！')
            }
        }
    })
})
</script>
@endsection