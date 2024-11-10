<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicForm extends Component
{
    public $fields = [];           // الحقول وأحجامها
    public $formData = [];         // القيم المدخلة في الحقول
    public $submitMethod = 'submit'; // الدالة الافتراضية للإرسال
    public $submitParams = [];     // عناصر إضافية للتمرير إلى دالة الإرسال

    public function mount($fields, $submitMethod = 'submit', $submitParams = [])
    {
        $this->fields = $fields;
        $this->submitMethod = $submitMethod;
        $this->submitParams = $submitParams;
    }

    public function submit(...$params)
    {
        // المعالجة الافتراضية، تتضمن استقبال عناصر إضافية
        // على سبيل المثال: يمكن استخدام $params[0] وهكذا
    }

    public function render()
    {
        return view('livewire.dynamic-form');
    }
}
