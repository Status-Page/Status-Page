<?php
return [
    'timezone' => 'Das :attribute muss eine gültige Zone sein.',
    'unique' => 'Das :attribute ist bereits belegt.',
    'uploaded' => 'Das :attribute konnte nicht hochgeladen werden.',
    'between' => [
        'array' => 'Das :attribute muss einen Wert zwischen :min und :max haben.',
        'string' => 'Das :attribute muss zwischen den Zeichen :min und :max liegen.',
        'numeric' => 'Das :attribute muss zwischen :min und :max liegen.',
        'file' => 'Das :attribute muss zwischen :min und :max Kilobytes liegen.',
    ],
    'dimensions' => 'Das :attribute hat ungültige Bildabmessungen.',
    'email' => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das :attribute muss mit einer der folgenden Angaben enden: :values.',
    'uuid' => 'Das :attribute muss eine gültige UUID sein.',
    'file' => 'Das :attribute muss eine Datei sein.',
    'image' => 'Das :attribute muss ein Bild sein.',
    'in' => 'Das ausgewählte :attribute ist ungültig.',
    'integer' => 'Das :attribute muss eine ganze Zahl sein.',
    'ip' => 'Das :attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das :attribute muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das :attribute muss ein gültiger JSON-String sein.',
    'max' => [
        'numeric' => 'Das :attribute darf nicht größer sein als :max.',
        'string' => 'Das :attribute darf nicht größer als :max Zeichen sein.',
        'file' => 'Das :attribute darf nicht größer sein als :max kilobytes.',
        'array' => 'Das :attribute darf nicht mehr als :max Elemente haben.',
    ],
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',
    'numeric' => 'Das :attribute muss eine Zahl sein.',
    'date_equals' => 'Das :attribute muss ein Datum sein, das gleich :date ist.',
    'date_format' => 'Das :attribute stimmt nicht mit dem Format :format überein.',
    'digits' => 'Das :attribute muss :digits Ziffern sein.',
    'digits_between' => 'Das :attribute muss zwischen den Ziffern :min und :max liegen.',
    'mimes' => 'Das :attribute muss eine Datei vom Typ: :values sein.',
    'mimetypes' => 'Das :attribute muss eine Datei vom Typ: :values sein.',
    'min' => [
        'numeric' => 'Das :attribute muss mindestens :min sein.',
        'file' => 'Das :attribute muss mindestens :min Kilobytes betragen.',
        'string' => 'Das :attribute muss mindestens :min Zeichen lang sein.',
        'array' => 'Das :attribute muss mindestens :min Elemente haben.',
    ],
    'active_url' => 'Das :attribute ist keine gültige URL.',
    'after' => 'Das :attribute muss ein Datum nach :date sein.',
    'after_or_equal' => 'Das :attribute muss ein Datum nach oder gleich :date sein.',
    'alpha' => 'Das :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Das :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Das :attribute muss ein Array sein.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'size' => [
        'array' => 'Das :attribute muss :size Elemente enthalten.',
        'numeric' => 'Das :attribute muss :size sein.',
        'file' => 'Das :attribute muss :size kilobytes sein.',
        'string' => 'Das :attribute muss :size Zeichen sein.',
    ],
    'required_without_all' => 'Das Feld :attribute ist erforderlich, wenn keines der :values vorhanden ist.',
    'same' => 'Das :attribute und :other müssen übereinstimmen.',
    'starts_with' => 'Das :attribute muss mit einer der folgenden Angaben beginnen: :values.',
    'string' => 'Das :attribute muss eine Zeichenkette sein.',
    'required_unless' => 'Das Feld :attribute ist erforderlich, sofern nicht :other in :values enthalten ist.',
    'required_with' => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_without' => 'Das Feld :attribute ist erforderlich, wenn :values nicht vorhanden ist.',
    'url' => 'Das Format :attribute ist ungültig.',
    /*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */
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
    'accepted' => 'Das :attribute muss akzeptiert werden.',
    'custom' => [
        'attribute-name' => [
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
            'rule-name' => 'benutzerdefinierte Nachricht',
        ],
    ],
    'before' => 'Das :attribute muss ein Datum vor :date sein.',
    'before_or_equal' => 'Das :attribute muss ein Datum vor oder gleich :date sein.',
    'boolean' => 'Das Feld :attribute muss true oder false sein.',
    'confirmed' => 'Das :attribute confirmation stimmt nicht überein.',
    'date' => 'Das :attribute ist kein gültiges Datum.',
    'different' => 'Das :attribute und :other müssen unterschiedlich sein.',
    'distinct' => 'Das Feld :attribute hat einen doppelten Wert.',
    'filled' => 'Das Feld :attribute muss einen Wert haben.',
    'gt' => [
        'numeric' => 'Das :attribute muss größer sein als :values.',
        'file' => 'Das :attribute muss größer als der :values Kilobytes sein.',
        'string' => 'Das :attribute muss größer sein als :value Zeichen.',
        'array' => 'Das :attribute muss mehr als :value haben.',
    ],
    'gte' => [
        'numeric' => 'Das :attribute muss größer oder gleich dem :value sein.',
        'file' => 'Das :attribute muss größer oder gleich dem :value Kilobytes sein.',
        'string' => 'Das :attribute muss größer oder gleich :value Zeichen sein.',
        'array' => 'Das :attribute muss mindestens :value Elemente haben.',
    ],
    'in_array' => 'Das Feld :attribute ist in :other nicht vorhanden.',
    'lt' => [
        'numeric' => 'Das :attribute muss kleiner sein als :value.',
        'file' => 'Das :attribute muss kleiner als der :value Kilobytes sein.',
        'string' => 'Das :attribute muss kleiner sein als :value Zeichen.',
        'array' => 'Das :attribute muss weniger als :value Elemente haben.',
    ],
    'lte' => [
        'numeric' => 'Das :attribute muss kleiner oder gleich :value sein.',
        'file' => 'Das :attribute muss kleiner oder gleich dem :value Kilobytes sein.',
        'string' => 'Das :attribute muss kleiner oder gleich :value Zeichen sein.',
        'array' => 'Das :attribute darf nicht mehr als :value Elemente haben.',
    ],
    'multiple_of' => 'Das :attribute muss ein Vielfaches von :value sein.',
    'not_regex' => 'Das Format :attribute ist ungültig.',
    'password' => 'Das Passwort ist falsch.',
    'present' => 'Das Feld :attribute muss vorhanden sein.',
    'regex' => 'Das Format :attribute ist ungültig.',
    'required_if' => 'Das Feld :attribute ist erforderlich, wenn :other :value ist.',
    'required' => 'Das Feld :attribute ist erforderlich.',
];
