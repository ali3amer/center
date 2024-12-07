<div>
    <div class="grid gap-x-1 grid-cols-3">
        <x-container title="المستخدمين">
            <form wire:submit="save">
                <x-input name="name" label="الإسم"/>
                <x-input name="username" label="الإسم المستخدم"/>
                <x-input name="password" type="password" label="كلمة السر"/>

                <x-button  model="users" type="submit" :center="true" label="حفظ"/>
            </form>
        </x-container>

        <x-container class="col-span-2">
            <x-table model="users" :headers="$headers" :rows="$users" :cells="$cells"/>
        </x-container>
    </div>

    <x-container>
        @if(Auth::user()->hasPermission('permissions-create'))
            <table class="table-fixed w-full text-center">
                <thead>
                <tr class="text-white bg-cyan-800">
                    <th>الصلاحية</th>
                    <th>عرض</th>
                    <th>إنشاء</th>
                    <th>تعديل</th>
                    <th>حذف</th>
                </tr>
                </thead>
                @foreach($permissionsList as $permission)
                    <tr class="py-2 border-b-2">
                        <td>{{$permission[1]}}</td>
                        <td><input class="form-check-input" type="checkbox" wire:model="permissions"
                                   value="{{$permission[0] . '-read'}}" value="" aria-label="..."></td>
                        <td><input class="form-check-input" type="checkbox" wire:model="permissions"
                                   value="{{$permission[0] . '-create'}}" value="" aria-label="..."></td>
                        <td><input class="form-check-input" type="checkbox" wire:model="permissions"
                                   value="{{$permission[0] . '-update'}}" value="" aria-label="..."></td>
                        <td><input class="form-check-input" type="checkbox" wire:model="permissions"
                                   value="{{$permission[0] . '-delete'}}" value="" aria-label="..."></td>
                    </tr>
                @endforeach
            </table>
        @endif
    </x-container>
</div>
