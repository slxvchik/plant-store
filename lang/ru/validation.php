<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute должно быть принято.',
    'accepted_if' => 'Поле :attribute должно быть принято, когда поле :other содержит значение :value.',
    'active_url' => 'Поле :attribute должно содержать корректный URL.',
    'after' => 'Поле :attribute должно быть датой после :date.',
    'after_or_equal' => 'Поле :attribute должно быть датой после или равной :date.',
    'alpha' => 'Поле :attribute может содержать только буквы.',
    'alpha_dash' => 'Поле :attribute может содержать только буквы, цифры, дефисы и подчеркивания.',
    'alpha_num' => 'Поле :attribute может содержать только буквы и цифры.',
    'any_of' => 'Поле :attribute содержит недопустимое значение.',
    'array' => 'Поле :attribute должно быть массивом.',
    'array_keys' => 'Поле :attribute должно содержать только следующие ключи: :values.',
    'ascii' => 'Поле :attribute должно содержать только однобайтовые буквенно-цифровые символы и знаки.',
    'base64' => 'Поле :attribute должно быть корректной строкой Base64.',
    'before' => 'Поле :attribute должно быть датой до :date.',
    'before_or_equal' => 'Поле :attribute должно быть датой до или равной :date.',
    'between' => [
        'array' => 'Количество элементов в поле :attribute должно быть от :min до :max.',
        'file' => 'Размер файла в поле :attribute должен быть от :min до :max КБ.',
        'numeric' => 'Значение поля :attribute должно быть от :min до :max.',
        'string' => 'Длина строки в поле :attribute должна быть от :min до :max символов.',
    ],
    'boolean' => 'Поле :attribute должно иметь значение true или false.',
    'can' => 'Поле :attribute содержит неразрешенное значение.',
    'confirmed' => 'Подтверждение поля :attribute не совпадает.',
    'contains' => 'В поле :attribute отсутствует обязательное значение.',
    'current_password' => 'Неверный пароль.',
    'date' => 'Поле :attribute должно быть корректной датой.',
    'date_equals' => 'Поле :attribute должно быть датой, равной :date.',
    'date_format' => 'Поле :attribute должно соответствовать формату :format.',
    'decimal' => 'Поле :attribute должно содержать :decimal знаков после запятой.',
    'declined' => 'Поле :attribute должно быть отклонено.',
    'declined_if' => 'Поле :attribute должно быть отклонено, когда поле :other содержит значение :value.',
    'different' => 'Поля :attribute и :other должны различаться.',
    'digits' => 'Поле :attribute должно содержать :digits цифр.',
    'digits_between' => 'Поле :attribute должно содержать от :min до :max цифр.',
    'dimensions' => 'Изображение в поле :attribute имеет недопустимые размеры.',
    'distinct' => 'Поле :attribute содержит повторяющееся значение.',
    'doesnt_contain' => 'Поле :attribute не должно содержать следующие значения: :values.',
    'doesnt_end_with' => 'Поле :attribute не должно заканчиваться одним из следующих значений: :values.',
    'doesnt_start_with' => 'Поле :attribute не должно начинаться с одного из следующих значений: :values.',
    'email' => 'Поле :attribute должно быть корректным email-адресом.',
    'encoding' => 'Поле :attribute должно быть закодировано в кодировке :encoding.',
    'ends_with' => 'Поле :attribute должно заканчиваться одним из следующих значений: :values.',
    'enum' => 'Выбранное значение для :attribute недопустимо.',
    'exists' => 'Выбранное значение для :attribute недопустимо.',
    'extensions' => 'Файл в поле :attribute должен иметь одно из следующих расширений: :values.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'Количество элементов в поле :attribute должно быть больше :value.',
        'file' => 'Размер файла в поле :attribute должен быть больше :value КБ.',
        'numeric' => 'Значение поля :attribute должно быть больше :value.',
        'string' => 'Длина строки в поле :attribute должна быть больше :value символов.',
    ],
    'gte' => [
        'array' => 'Количество элементов в поле :attribute должно быть :value или больше.',
        'file' => 'Размер файла в поле :attribute должен быть :value КБ или больше.',
        'numeric' => 'Значение поля :attribute должно быть :value или больше.',
        'string' => 'Длина строки в поле :attribute должна быть :value символов или больше.',
    ],
    'hex_color' => 'Поле :attribute должно быть корректным шестнадцатеричным цветом.',
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранное значение для :attribute недопустимо.',
    'in_array' => 'Поле :attribute должно существовать в :other.',
    'in_array_keys' => 'Поле :attribute должно содержать хотя бы один из следующих ключей: :values.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'ip' => 'Поле :attribute должно быть корректным IP-адресом.',
    'ipv4' => 'Поле :attribute должно быть корректным IPv4-адресом.',
    'ipv6' => 'Поле :attribute должно быть корректным IPv6-адресом.',
    'json' => 'Поле :attribute должно быть корректной JSON-строкой.',
    'list' => 'Поле :attribute должно быть списком.',
    'lowercase' => 'Поле :attribute должно быть в нижнем регистре.',
    'lt' => [
        'array' => 'Количество элементов в поле :attribute должно быть меньше :value.',
        'file' => 'Размер файла в поле :attribute должен быть меньше :value КБ.',
        'numeric' => 'Значение поля :attribute должно быть меньше :value.',
        'string' => 'Длина строки в поле :attribute должна быть меньше :value символов.',
    ],
    'lte' => [
        'array' => 'Количество элементов в поле :attribute не должно превышать :value.',
        'file' => 'Размер файла в поле :attribute должен быть :value КБ или меньше.',
        'numeric' => 'Значение поля :attribute должно быть :value или меньше.',
        'string' => 'Длина строки в поле :attribute должна быть :value символов или меньше.',
    ],
    'mac_address' => 'Поле :attribute должно быть корректным MAC-адресом.',
    'max' => [
        'array' => 'Количество элементов в поле :attribute не должно превышать :max.',
        'file' => 'Размер файла в поле :attribute не должен превышать :max КБ.',
        'numeric' => 'Значение поля :attribute не должно превышать :max.',
        'string' => 'Длина строки в поле :attribute не должна превышать :max символов.',
    ],
    'max_digits' => 'Поле :attribute не должно содержать более :max цифр.',
    'mimes' => 'Файл в поле :attribute должен быть одного из следующих типов: :values.',
    'mimetypes' => 'Файл в поле :attribute должен быть одного из следующих типов: :values.',
    'min' => [
        'array' => 'Количество элементов в поле :attribute должно быть не менее :min.',
        'file' => 'Размер файла в поле :attribute должен быть не менее :min КБ.',
        'numeric' => 'Значение поля :attribute должно быть не менее :min.',
        'string' => 'Длина строки в поле :attribute должна быть не менее :min символов.',
    ],
    'min_digits' => 'Поле :attribute должно содержать не менее :min цифр.',
    'missing' => 'Поле :attribute должно отсутствовать.',
    'missing_if' => 'Поле :attribute должно отсутствовать, когда поле :other содержит значение :value.',
    'missing_unless' => 'Поле :attribute должно отсутствовать, если поле :other не содержит значение :value.',
    'missing_with' => 'Поле :attribute должно отсутствовать, когда присутствуют значения :values.',
    'missing_with_all' => 'Поле :attribute должно отсутствовать, когда присутствуют все значения :values.',
    'multiple_of' => 'Поле :attribute должно быть кратным :value.',
    'not_in' => 'Выбранное значение для :attribute недопустимо.',
    'not_regex' => 'Поле :attribute имеет неверный формат.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'password' => [
        'letters' => 'Поле :attribute должно содержать хотя бы одну букву.',
        'mixed' => 'Поле :attribute должно содержать хотя бы одну заглавную и одну строчную букву.',
        'numbers' => 'Поле :attribute должно содержать хотя бы одну цифру.',
        'symbols' => 'Поле :attribute должно содержать хотя бы один специальный символ.',
        'uncompromised' => 'Указанное значение :attribute было найдено в утечках данных. Пожалуйста, выберите другое значение.',
    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'present_if' => 'Поле :attribute должно присутствовать, когда поле :other содержит значение :value.',
    'present_unless' => 'Поле :attribute должно присутствовать, если поле :other не содержит значение :value.',
    'present_with' => 'Поле :attribute должно присутствовать, когда присутствуют значения :values.',
    'present_with_all' => 'Поле :attribute должно присутствовать, когда присутствуют все значения :values.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда поле :other содержит значение :value.',
    'prohibited_if_accepted' => 'Поле :attribute запрещено, когда поле :other принято.',
    'prohibited_if_declined' => 'Поле :attribute запрещено, когда поле :other отклонено.',
    'prohibited_unless' => 'Поле :attribute запрещено, если поле :other не содержит одно из значений: :values.',
    'prohibits' => 'Поле :attribute запрещает наличие поля :other.',
    'regex' => 'Поле :attribute имеет неверный формат.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute обязательно, когда поле :other содержит значение :value.',
    'required_if_accepted' => 'Поле :attribute обязательно, когда поле :other принято.',
    'required_if_declined' => 'Поле :attribute обязательно, когда поле :other отклонено.',
    'required_unless' => 'Поле :attribute обязательно, если поле :other не содержит одно из значений: :values.',
    'required_with' => 'Поле :attribute обязательно, когда присутствуют значения :values.',
    'required_with_all' => 'Поле :attribute обязательно, когда присутствуют все значения :values.',
    'required_without' => 'Поле :attribute обязательно, когда отсутствуют значения :values.',
    'required_without_all' => 'Поле :attribute обязательно, когда отсутствуют все значения :values.',
    'same' => 'Поле :attribute должно совпадать с :other.',
    'size' => [
        'array' => 'Поле :attribute должно содержать :size элементов.',
        'file' => 'Размер файла в поле :attribute должен быть :size КБ.',
        'numeric' => 'Значение поля :attribute должно быть :size.',
        'string' => 'Длина строки в поле :attribute должна быть :size символов.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться с одного из следующих значений: :values.',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть корректным часовым поясом.',
    'unique' => 'Такое значение поля :attribute уже существует.',
    'uploaded' => 'Загрузка файла в поле :attribute не удалась.',
    'uppercase' => 'Поле :attribute должно быть в верхнем регистре.',
    'url' => 'Поле :attribute должно содержать корректный URL.',
    'ulid' => 'Поле :attribute должно быть корректным ULID.',
    'uuid' => 'Поле :attribute должно быть корректным UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
