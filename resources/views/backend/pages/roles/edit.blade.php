@extends('backend.layouts.layouts')
@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit Roles</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('roles.update',$role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                        <input class="form-control" type="text" placeholder="name" value="{{$role->name}}" id="name" name="name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" name="" class="form-check-input" id="checkPermissionAll" value="1" {{ App\User::roleHasPermissions($role, $permissions) ? 'checked':'' }} />
                                <label class="form-check-label" for="check-permissionAll">All</label>
                            </div>
                            <hr>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($groups as $group)
                                <div class="row">
                                    @php
                                        $permissions = App\User::getpermissionByGroupName($group->group_name);
                                        $j = 1;
                                    @endphp
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                        id="Management{{$i}}" value="1" onclick="checkPermissionByGroup('role-{{$i}}-management-checkbox', this)" {{ App\User::roleHasPermissions($role, $permissions) ? 'checked':'' }} />
                                            <label class="form-check-label"
                                                for="check-permission{{ $group->group_name }}">{{ $group->group_name }}</label>
                                        </div>
                                    </div>
                                <div class="col-md-9 role-{{$i}}-management-checkbox">
                                        
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permission[]" class="form-check-input" {{$role->hasPermissionTo($permission->name) ? 'checked':''}}
                                                    id="check-permission{{ $permission->id }}"
                                                    value="{{ $permission->id }}" />
                                                <label class="form-check-label"
                                                    for="check-permission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                            @php
                                            $j ++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                @php $i ++; @endphp
                            @endforeach


                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pl-4 pr-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#checkPermissionAll").click(function() {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        });
        function checkPermissionByGroup(className, checkThis){
            const groupIdName = $('#' + checkThis.id);
            const classCheckBox = $('.' + className + ' input');

            if (groupIdName.is(':checked')) {
                classCheckBox.prop('checked', true);
            } else {
                classCheckBox.prop('checked', false);
            }

        }

    </script>
@endsection
