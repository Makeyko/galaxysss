<?php


namespace cs\models\Tables;

use cs\services\DataSets;
use cs\Widget\FileUpload\FileUpload;
use cs\Widget\FileUploadMany\FileUploadMany;
use cs\Widget\Place\Place;
use cs\Widget\RadioList\RadioList;

class Client extends \cs\base\BaseTable
{
    protected static $fields;

    protected static function getFields()
    {
        return [
            //[имя поля БД, название поля рус, обязательное поле?, проверка, параметры]
            [
                'avatar', 'Аватар', 0,
                'file',
                ['mimeTypes' => 'image/jpeg, image/png'],
                'widget' => [
                    \cs\Widget\FileUpload2\FileUpload::className(),
                    [
                        'options' => [
                            'small'      => [
                                300,
                                300,
                                FileUpload::MODE_THUMBNAIL_OUTBOUND
                            ],
                            'original'   => [
                                3000,
                                3000
                            ],
                            'quality'    => 80,
                            'folder'     => 'users',
                            'serverName' => 'http://' . \cs\models\Client::getServerName(),
                        ]
                    ]
                ]
            ],
            [
                'name_first',
                'Имя',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 100
                ]
            ],
            [
                'name_last',
                'Фамилия',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 100
                ]
            ],
            [
                'name_middle',
                'Отчество',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 100
                ]
            ],
            [
                'gender',
                'Пол',
                1,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\models\Client::$genderList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],
            [
                'phone',
                'Телефон',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 100
                ],
                'widget' => [
                    \yii\widgets\MaskedInput::className(),
                    ['mask' => '+7(999) 999-99-99']
                ],
            ],
            [
                'place',
                'Место взятия кредита',
                0,
                'type' => 'place'
            ],
            [
                'date_birth',
                'Дата рождения',
                1,
                'date',
                [
                    'format' => 'php:d.m.Y',
                    'min'    => '01.01.1970',
                    'max'    => 'now'
                ],
                'Формат дд.мм.гггг',
            ],
            [
                'file_passport',
                'Паспорт',
                0,
                'file',
                ['mimeTypes' => 'image/jpeg, image/png'],
                'widget' => [
                    \cs\Widget\FileUploadMany\FileUploadMany::className(), [
                        'tableName' => 'cs_users',
                    ]
                ]
            ],
            [
                'file_passport_ser',
                'Паспорт. Серия',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 4
                ],
                'widget' => [
                    \yii\widgets\MaskedInput::className(),
                    ['mask' => '9999']
                ],
            ],
            [
                'file_passport_number',
                'Паспорт. Номер',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 6
                ],
                'widget' => [
                    \yii\widgets\MaskedInput::className(),
                    ['mask' => '999999']
                ],
            ],
            [
                'file_passport_vidan_kem',
                'Паспорт. Кем выдан?',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            [
                'file_passport_vidan_kogda',
                'Паспорт. Когда выдан?',
                1,
                'date',
                [
                    'format' => 'php:d.m.Y',
                    'min'    => '01.01.1970',
                    'max'    => 'now'
                ],
                'Формат дд.мм.гггг',
            ],
            [
                'file_passport_registration_address',
                'Паспорт. Адрес регистрации',
                1,
                'string',
                [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            [
                'file_passport_registration_date',
                'Паспорт. Дата регистрации',
                1,
                'date',
                [
                    'format' => 'php:d.m.Y',
                    'min'    => '01.01.1970',
                    'max'    => 'now'
                ],
                'Формат дд.мм.гггг',
            ],
            [
                's_file_2ndfl',
                'Справка 2НДФЛ',
                0,
                'file',
                ['mimeTypes' => 'image/jpeg, image/png'],
                'widget' => [
                    \cs\Widget\FileUploadMany\FileUploadMany::className(), [
                        'tableName' => 'cs_users',
                    ]
                ],
            ],
            [
                's_file_second_identy',
                'Второй документ, удостоверяющий личность',
                0,
                'file',
                ['mimeTypes' => 'image/jpeg, image/png'],
                'widget' => [
                    \cs\Widget\FileUploadMany\FileUploadMany::className(), [
                        'tableName' => 'cs_users',
                    ]
                ],
            ],
            [
                's_file_confirmation_payment',
                'Документы, подтверждающие наличие первоначального взноса',
                0,
                'file',
                ['mimeTypes' => 'image/jpeg, image/png'],
                'widget' => [
                    \cs\Widget\FileUploadMany\FileUploadMany::className(), [
                        'tableName' => 'cs_users',
                    ]
                ],
            ],
            [
                'i_is_mat_kap',
                'Есть материнский капитал?',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\services\DataSets::$booleanList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],



            [
                'lives_place',
                'Место проживания',
                0,
                'widget' => [
                    Place::className(), []
                ],
            ],
            [
                'lives_place_address',
                'Адрес',
                0,
                'string',
                [
                    'max' => 255,
                ],
                'Укажите только улицу',
            ],
            [
                'lives_place_house',
                'Дом',
                0,
                'integer',
            ],
            [
                'snils_fotos',
                'Фото снилса',
                0,
                'integer',
                'widget' => [
                    FileUploadMany::className(), []
                ]
            ],
            [
                'lives_place_korp',
                'Корпус',
                0,
                'integer',
            ],
            [
                'lives_place_kv',
                'Квартира',
                0,
                'integer',
            ],
            [
                'lives_is_same_as_file_passport_registration',
                'Место жительсва совпвдает с местом прописки?',
                1,
                'integer',
                'widget' => [
                    RadioList::className(), [
                        'list' => DataSets::$booleanList
                    ]
                ],
            ],

            [
                'file_passport_registration_place',
                'Место регистрации',
                0,
                'integer',
                'widget' => [
                    Place::className()
                ]
            ],
            [
                'file_passport_registration_house',
                'Квартира',
                0,
                'integer',
            ],
            [
                'file_passport_registration_korp',
                'Квартира',
                0,
                'integer',
            ],
            [
                'file_passport_registration_kv',
                'Квартира',
                0,
                'integer',
            ],
            [
                's_is_change_famaly_name',
                'Меняли фамилию?',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list' => \cs\services\DataSets::$booleanList,
                    ]
                ],

            ],
            [
                's_prevision_famaly_name',
                'Прошлая фамилия',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 45
                ]
            ],
            [
                's_prevision_famaly_date',
                'Прошлая фамилия. Дата смены',
                0,
                'date',
                [
                    'format' => 'php:d.m.Y',
                    'min' => '01.01.1970',
                    'max' => 'now',
                ],
                'Формат дд.мм.гггг',
            ],
            [
                's_education',
                'Образование',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            [
                's_is_sud',
                'Есть судимость?',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\services\DataSets::$booleanList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],
            ],
            [
                's_is_sud_neisp_resh',
                'Наличие неисполненных решений судебных органов?',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\services\DataSets::$booleanList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],
            [
                's_is_sud_sud_isk',
                'Наличие против Вас судебных исков?',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\services\DataSets::$booleanList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],
            ],
            [
                's_is_work_now',
                'Работаете?',
                1,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\services\DataSets::$booleanList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],
            ],
            [
                's_work_now_name',
                'Сведения о работе. - имя организации',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            [
                's_work_now_kol_sotr',
                'Сведения о работе. - количество сотрудников',
                0,
                'integer'
            ],
            [
                's_alt_income',
                'Альтернативный источник дохода',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 45
                ]
            ],
            [
                's_is_childrens',
                'Есть дети?',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\services\DataSets::$booleanList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],
            [
                's_is_guarantee',
                'Есть залог?',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\services\DataSets::$booleanList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],
            [
                's_snils',
                'СНИЛС',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 45
                ],
                'widget' => [
                    \yii\widgets\MaskedInput::className(),
                    ['mask' => '999-999-999-99']
                ],
            ],
            [
                's_auto',
                'Транспортные средства',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 255
                ]
            ],
            [
                'i_co_borrowers',
                'Созаемщики',
                0,
                'string',
                [],
                '(ФИО, тел)',
                'type' => [
                    'textarea',
                    ['rows' => 10]
                ]
            ],
            [
                'i_rodnie_list',
                'Данные родственников',
                0,
                'string',
                [],
                '(ФИО, тел)',
                'type' => [
                    'textarea',
                    ['rows' => 10]
                ]
            ],
            [
                'stage_last',
                'Стаж на последнем месте работы',
                0,
                'integer',
                [],
                '(в мес)'
            ],
            [
                's_stage_all',
                'Стаж весь',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 45
                ],
                '(в годах)'
            ],
            [
                'status',
                'Статус',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\models\Client::$statusList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],
            [
                's_marital_status',
                'Семейное положение',
                1,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\models\Client::$maritalStatusList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],
            [
                's_home_type',
                'проживание',
                0,
                'integer',
                'type' => [
                    'RadioList',
                    [
                        'list'       => \cs\models\Client::$homeTypeList,
                        'nullString' => 'Ничего не выбрано'
                    ]
                ],

            ],
            [
                's_expense',
                'Расходы',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 45
                ]
            ],
            [
                'i_info_imush',
                'Сведения об имуществе',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 255
                ],
                'type' => [
                    'textarea',
                    ['rows' => 10]
                ]
            ],
        ];
    }
}