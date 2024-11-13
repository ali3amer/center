<div>

    <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
        <livewire:dynamic-form
            :fields="[
                ['name' => 'name', 'label' => 'الإسم', 'width' => '1/3'],
                ['name' => 'email', 'label' => 'الإيميل', 'width' => '1/3'],
                ['name' => 'phone', 'label' => 'الهاتف', 'width' => '1/6'],
            ]"
            submit-method="customSubmit"
            :submit-params="['parameter1', 42]"
        />
    </div>


    <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
        @php
            $columns = ['الاسم', 'الايميل', 'الهاتف', 'hg' , 'hg'];
            $data = [
                ['id' => 1, 'الاسم' => 'Ahmed Ahmed Ahmed Ahmed Ahmed', 'الايميل' => 'ahmed@example.com', 'الهاتف' => '123456789'],
            ];
        @endphp

        <div class="overflow-x-auto">
            <livewire:dynamic-table :columns="$columns" :data="$data" />
        </div>
    </div>

    </div>
