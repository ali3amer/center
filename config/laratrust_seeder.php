<?php

return [
    'roles_structure' => [
        'super_admin' => [
            'banks' => 'c,r,u,d',
            'batches' => 'c,r,u,d',
            'batchStudents' => 'c,r,u,d',
            'batchStudentPayments' => 'c,r,u,d',
            'certifications' => 'c,r,u,d',
            'courses' => 'c,r,u,d',
            'employees' => 'c,r,u,d',
            'employeeExpenses' => 'c,r,u,d',
            'expenses' => 'c,r,u,d',
            'expenseOptions' => 'c,r,u,d',
            'halls' => 'c,r,u,d',
            'hallRentals' => 'c,r,u,d',
            'hallRentalPayments' => 'c,r,u,d',
            'reports' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'students' => 'c,r,u,d',
            'trainers' => 'c,r,u,d',
            'trainerBatches' => 'c,r,u,d',
            'batchTrainerPayments' => 'c,r,u,d',
            'transfers' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'users' => 'c,r,u,d',
        ],
        'user' => []
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
