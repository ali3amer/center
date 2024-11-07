<div>
    <form class="w-full" wire:submit="save()">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                       for="patientName">
                    إسم المريض
                </label>
                <input autocomplete="off" required
                        wire:model="patientName"
                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                       id="patientName" type="text" placeholder="إسم المريض">
                <span class="text-red-500">@error('patientName') {{ $message }} @enderror</span>
            </div>

            <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                       for="gender">
                    النوع
                </label>
                <select wire:model="gender"
                        @disabled(!empty($currentPatient)) class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="gender">
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>

            </div>

            <div class="w-full md:w-1/12 px-2  flex items-center ">
                <button type="submit"
                        class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
            </div>
        </div>

    </form>
</div>
