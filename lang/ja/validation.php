<?php

return [

   

    'accepted' => ':attribute フィールドを承認する必要があります。',
    'accepted_if' => ':other が :value の場合、:attribute フィールドを承認する必要があります。',
    'active_url' => ':attribute フィールドは有効な URL である必要があります。',
    'after' => ':attribute フィールドは :date より後の日付である必要があります。',
    'after_or_equal' => ':attribute フィールドは :date 以降の日付である必要があります。',
    'alpha' => ':attribute フィールドは文字のみを含む必要があります。',
    'alpha_dash' => ':attribute フィールドは文字、数字、ダッシュ、アンダースコアのみを含む必要があります。',
    'alpha_num' => ':attribute フィールドは文字と数字のみを含む必要があります。',
    'array' => ':attribute フィールドは配列である必要があります。',
    'ascii' => ':attribute フィールドは半角英数字と記号のみを含む必要があります。',
    'before' => ':attribute フィールドは :date より前の日付である必要があります。',
    'before_or_equal' => ':attribute フィールドは :date 以前の日付である必要があります。',
    'between' => [
        'array' => ':attribute フィールドは :min から :max 個のアイテムを持つ必要があります。',
        'file' => ':attribute フィールドは :min から :max キロバイトの間である必要があります。',
        'numeric' => ':attribute フィールドは :min から :max の間である必要があります。',
        'string' => ':attribute フィールドは :min から :max 文字の間である必要があります。',
    ],
    'boolean' => ':attribute フィールドは true または false である必要があります。',
    'can' => ':attribute フィールドに許可されていない値が含まれています。',
    'confirmed' => ':attribute フィールドの確認が一致しません。',
    'contains' => ':attribute フィールドに必要な値が欠けています。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attribute フィールドは有効な日付である必要があります。',
    'date_equals' => ':attribute フィールドは :date と等しい日付である必要があります。',
    'date_format' => ':attribute フィールドは :format 形式と一致する必要があります。',
    'decimal' => ':attribute フィールドは :decimal 桁の小数点以下の数字を持つ必要があります。',
    'declined' => ':attribute フィールドは拒否される必要があります。',
    'declined_if' => ':other が :value の場合、:attribute フィールドは拒否される必要があります。',
    'different' => ':attribute フィールドと :other は異なる必要があります。',
    'digits' => ':attribute フィールドは :digits 桁である必要があります。',
    'digits_between' => ':attribute フィールドは :min から :max 桁の間である必要があります。',
    'dimensions' => ':attribute フィールドの画像サイズが無効です。',
    'distinct' => ':attribute フィールドに重複した値があります。',
    'doesnt_end_with' => ':attribute フィールドは次のいずれかで終わってはいけません: :values',
    'doesnt_start_with' => ':attribute フィールドは次のいずれかで始まってはいけません: :values',
    'email' => ':attribute フィールドは有効なメールアドレスである必要があります。',
    'ends_with' => ':attribute フィールドは次のいずれかで終わる必要があります: :values',
    'enum' => '選択された :attribute は無効です。',
    'exists' => '選択された :attribute は無効です。',
    'extensions' => ':attribute フィールドは次のいずれかの拡張子を持つ必要があります: :values',
    'file' => ':attribute フィールドはファイルである必要があります。',
    'filled' => ':attribute フィールドは値を持つ必要があります。',
    'gt' => [
        'array' => ':attribute フィールドは :value 個より多くのアイテムを持つ必要があります。',
        'file' => ':attribute フィールドは :value キロバイトより大きい必要があります。',
        'numeric' => ':attribute フィールドは :value より大きい必要があります。',
        'string' => ':attribute フィールドは :value 文字より多い必要があります。',
    ],
    'gte' => [
        'array' => ':attribute フィールドは :value 個以上のアイテムを持つ必要があります。',
        'file' => ':attribute フィールドは :value キロバイト以上である必要があります。',
        'numeric' => ':attribute フィールドは :value 以上である必要があります。',
        'string' => ':attribute フィールドは :value 文字以上である必要があります。',
    ],
    'hex_color' => ':attribute フィールドは有効な16進数カラーコードである必要があります。',
    'image' => ':attribute フィールドは画像である必要があります。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute フィールドは :other に存在する必要があります。',
    'integer' => ':attribute フィールドは整数である必要があります。',
    'ip' => ':attribute フィールドは有効な IP アドレスである必要があります。',
    'ipv4' => ':attribute フィールドは有効な IPv4 アドレスである必要があります。',
    'ipv6' => ':attribute フィールドは有効な IPv6 アドレスである必要があります。',
    'json' => ':attribute フィールドは有効な JSON 文字列である必要があります。',
    'list' => ':attribute フィールドはリストである必要があります。',
    'lowercase' => ':attribute フィールドは小文字である必要があります。',
    'lt' => [
        'array' => ':attribute フィールドは :value 個未満のアイテムを持つ必要があります。',
        'file' => ':attribute フィールドは :value キロバイト未満である必要があります。',
        'numeric' => ':attribute フィールドは :value 未満である必要があります。',
        'string' => ':attribute フィールドは :value 文字未満である必要があります。',
    ],
    'lte' => [
        'array' => ':attribute フィールドは :value 個以下のアイテムを持つ必要があります。',
        'file' => ':attribute フィールドは :value キロバイト以下である必要があります。',
        'numeric' => ':attribute フィールドは :value 以下である必要があります。',
        'string' => ':attribute フィールドは :value 文字以下である必要があります。',
    ],
    'mac_address' => ':attribute フィールドは有効な MAC アドレスである必要があります。',
    'max' => [
        'array' => ':attribute フィールドは :max 個以下のアイテムを持つ必要があります。',
        'file' => ':attribute フィールドは :max キロバイト以下である必要があります。',
        'numeric' => ':attribute フィールドは :max 以下である必要があります。',
        'string' => ':attribute フィールドは :max 文字以下である必要があります。',
    ],
    'max_digits' => ':attribute フィールドは :max 桁以下である必要があります。',
    'mimes' => ':attribute フィールドは次のタイプのファイルである必要があります: :values',
    'mimetypes' => ':attribute フィールドは次のタイプのファイルである必要があります: :values',
    'min' => [
        'array' => ':attribute フィールドは少なくとも :min 個のアイテムを持つ必要があります。',
        'file' => ':attribute フィールドは少なくとも :min キロバイトである必要があります。',
        'numeric' => ':attribute フィールドは少なくとも :min である必要があります。',
        'string' => ':attribute フィールドは少なくとも :min 文字である必要があります。',
    ],
    'min_digits' => ':attribute フィールドは少なくとも :min 桁である必要があります。',
    'missing' => ':attribute フィールドが欠けている必要があります。',
    'missing_if' => ':other が :value の場合、:attribute フィールドが欠けている必要があります。',
    'missing_unless' => ':other が :value でない限り、:attribute フィールドが欠けている必要があります。',
    'missing_with' => ':values が存在する場合、:attribute フィールドが欠けている必要があります。',
    'missing_with_all' => ':values が存在する場合、:attribute フィールドが欠けている必要があります。',
    'multiple_of' => ':attribute フィールドは :value の倍数である必要があります。',
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute フィールドの形式が無効です。',
    'numeric' => ':attribute フィールドは数値である必要があります。',
    'password' => [
        'letters' => ':attribute フィールドは少なくとも1つの文字を含む必要があります。',
        'mixed' => ':attribute フィールドは少なくとも1つの大文字と1つの小文字を含む必要があります。',
        'numbers' => ':attribute フィールドは少なくとも1つの数字を含む必要があります。',
        'symbols' => ':attribute フィールドは少なくとも1つの記号を含む必要があります。',
        'uncompromised' => '指定された :attribute はデータ漏洩に現れています。別の :attribute を選択してください。',
    ],
    'present' => ':attribute フィールドが存在する必要があります。',
    'present_if' => ':other が :value の場合、:attribute フィールドが存在する必要があります。',
    'present_unless' => ':other が :value でない限り、:attribute フィールドが存在する必要があります。',
    'present_with' => ':values が存在する場合、:attribute フィールドが存在する必要があります。',
    'present_with_all' => ':values が存在する場合、:attribute フィールドが存在する必要があります。',
    'prohibited' => ':attribute フィールドは禁止されています。',
    'prohibited_if' => ':other が :value の場合、:attribute フィールドは禁止されています。',
    'prohibited_unless' => ':other が :values にない限り、:attribute フィールドは禁止されています。',
    'prohibits' => ':attribute フィールドは :other の存在を禁止しています。',
    'regex' => ':attribute フィールドの形式が無効です。',
    'required' => ':attribute フィールドは必須です。',
    'required_array_keys' => ':attribute フィールドには次の項目を含む必要があります: :values',
    'required_if' => ':other が :value の場合、:attribute フィールドは必須です。',
    'required_if_accepted' => ':other が承認された場合、:attribute フィールドは必須です。',
    'required_if_declined' => ':other が拒否された場合、:attribute フィールドは必須です。',
    'required_unless' => ':other が :values にない限り、:attribute フィールドは必須です。',
    'required_with' => ':values が存在する場合、:attribute フィールドは必須です。',
    'required_with_all' => ':values が存在する場合、:attribute フィールドは必須です。',
    'required_without' => ':values が存在しない場合、:attribute フィールドは必須です。',
    'required_without_all' => ':values のいずれも存在しない場合、:attribute フィールドは必須です。',
    'same' => ':attribute フィールドは :other と一致する必要があります。',
    'size' => [
        'array' => ':attribute フィールドは :size 個のアイテムを含む必要があります。',
        'file' => ':attribute フィールドは :size キロバイトである必要があります。',
        'numeric' => ':attribute フィールドは :size である必要があります。',
        'string' => ':attribute フィールドは :size 文字である必要があります。',
    ],
    'starts_with' => ':attribute フィールドは次のいずれかで始まる必要があります: :values',
    'string' => ':attribute フィールドは文字列である必要があります。',
    'timezone' => ':attribute フィールドは有効なタイムゾーンである必要があります。',
    'unique' => ':attribute はすでに使用されています。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'uppercase' => ':attribute フィールドは大文字である必要があります。',
    'url' => ':attribute フィールドは有効な URL である必要があります。',
    'ulid' => ':attribute フィールドは有効な ULID である必要があります。',
    'uuid' => ':attribute フィールドは有効な UUID である必要があります。',

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
