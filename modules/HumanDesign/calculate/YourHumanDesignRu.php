<?php

namespace app\modules\HumanDesign\calculate;

use cs\services\VarDumper;

/**
 * Получает данные для Дизайна Человека
 *
 * Class HumanDesign
 *
 * @package app\services
 *
 */
class YourHumanDesignRu
{
    public $url = 'http://yourhumandesign.ru/modules/mod_mapgen/tmpl/result.php';

    public static $countryList = [
        "Австралия"                        => 'Австралия',
        "Австрия"                          => 'Австрия',
        "Азербайджан"                      => 'Азербайджан',
        "Албания"                          => 'Албания',
        "Алжир"                            => 'Алжир',
        "Ангола"                           => 'Ангола',
        "Андорра"                          => 'Андорра',
        "Аргентина"                        => 'Аргентина',
        "Армения"                          => 'Армения',
        "Афганистан"                       => 'Афганистан',
        "Багамские острова"                => 'Багамские острова',
        "Бангладеш"                        => 'Бангладеш',
        "Барбадос"                         => 'Барбадос',
        "Бахрейн"                          => 'Бахрейн',
        "Белиз"                            => 'Белиз',
        "Белоруссия"                       => 'Белоруссия',
        "Бельгия"                          => 'Бельгия',
        "Бенин"                            => 'Бенин',
        "Болгария"                         => 'Болгария',
        "Боливия"                          => 'Боливия',
        "Босния и Герцеговина"             => 'Босния и Герцеговина',
        "Ботсвана"                         => 'Ботсвана',
        "Бразилия"                         => 'Бразилия',
        "Буркина-Фасо"                     => 'Буркина-Фасо',
        "Бурунди"                          => 'Бурунди',
        "Бутан"                            => 'Бутан',
        "Вануату"                          => 'Вануату',
        "Великобритания"                   => 'Великобритания',
        "Венгрия"                          => 'Венгрия',
        "Венесуэла"                        => 'Венесуэла',
        "Вьетнам"                          => 'Вьетнам',
        "Габон"                            => 'Габон',
        "Гаити"                            => 'Гаити',
        "Гайана"                           => 'Гайана',
        "Гамбия"                           => 'Гамбия',
        "Гана"                             => 'Гана',
        "Гватемала"                        => 'Гватемала',
        "Гвинея"                           => 'Гвинея',
        "Гвинея-Бисау"                     => 'Гвинея-Бисау',
        "Германия"                         => 'Германия',
        "Голландия"                        => 'Голландия',
        "Гондурас"                         => 'Гондурас',
        "Гренада"                          => 'Гренада',
        "Гренландия"                       => 'Гренландия',
        "Греция"                           => 'Греция',
        "Грузия"                           => 'Грузия',
        "Гуам"                             => 'Гуам',
        "Дания"                            => 'Дания',
        "Демократическая Республика Конго" => 'Демократическая Республика Конго',
        "Джибути"                          => 'Джибути',
        "Доминиканская республика"         => 'Доминиканская республика',
        "Египет"                           => 'Египет',
        "Замбия"                           => 'Замбия',
        "Зимбабве"                         => 'Зимбабве',
        "Израиль"                          => 'Израиль',
        "Индия"                            => 'Индия',
        "Индонезия"                        => 'Индонезия',
        "Иордания"                         => 'Иордания',
        "Ирак"                             => 'Ирак',
        "Иран"                             => 'Иран',
        "Ирландия"                         => 'Ирландия',
        "Исландия"                         => 'Исландия',
        "Испания"                          => 'Испания',
        "Италия"                           => 'Италия',
        "Йемен"                            => 'Йемен',
        "Кабо-Верде"                       => 'Кабо-Верде',
        "Казахстан"                        => 'Казахстан',
        "Камбоджа"                         => 'Камбоджа',
        "Камерун"                          => 'Камерун',
        "Канада"                           => 'Канада',
        "Катар"                            => 'Катар',
        "Кения"                            => 'Кения',
        "Кипр"                             => 'Кипр',
        "Киргизия"                         => 'Киргизия',
        "Кирибати"                         => 'Кирибати',
        "Китай"                            => 'Китай',
        "КНДР"                             => 'КНДР',
        "Колумбия"                         => 'Колумбия',
        "Коморские острова"                => 'Коморские острова',
        "Корея (Северная)"                 => 'Корея (Северная)',
        "Корея (Южная)"                    => 'Корея (Южная)',
        "Коста-Рика"                       => 'Коста-Рика',
        "Кот-д\'Ивуар"                     => 'Кот-д\'Ивуар',
        "Куба"                             => 'Куба',
        "Кувейт"                           => 'Кувейт',
        "Лаос"                             => 'Лаос',
        "Латвия"                           => 'Латвия',
        "Лесото"                           => 'Лесото',
        "Либерия"                          => 'Либерия',
        "Ливан"                            => 'Ливан',
        "Ливия"                            => 'Ливия',
        "Литва"                            => 'Литва',
        "Лихтенштейн"                      => 'Лихтенштейн',
        "Люксембург"                       => 'Люксембург',
        "Маврикий"                         => 'Маврикий',
        "Мавритания"                       => 'Мавритания',
        "Мадагаскар"                       => 'Мадагаскар',
        "Македония"                        => 'Македония',
        "Малави"                           => 'Малави',
        "Малайзия"                         => 'Малайзия',
        "Мали"                             => 'Мали',
        "Мальдивы"                         => 'Мальдивы',
        "Мальта"                           => 'Мальта',
        "Марокко"                          => 'Марокко',
        "Мартиника"                        => 'Мартиника',
        "Мексика"                          => 'Мексика',
        "Микронезия"                       => 'Микронезия',
        "Мозамбик"                         => 'Мозамбик',
        "Молдавия"                         => 'Молдавия',
        "Монако"                           => 'Монако',
        "Монголия"                         => 'Монголия',
        "Мьянма"                           => 'Мьянма',
        "Намибия"                          => 'Намибия',
        "Непал"                            => 'Непал',
        "Нигер"                            => 'Нигер',
        "Нигерия"                          => 'Нигерия',
        "Никарагуа"                        => 'Никарагуа',
        "Новая Зеландия"                   => 'Новая Зеландия',
        "Новая Каледония"                  => 'Новая Каледония',
        "Норвегия"                         => 'Норвегия',
        "ОАЭ"                              => 'ОАЭ',
        "Оман"                             => 'Оман',
        "Пакистан"                         => 'Пакистан',
        "Панама"                           => 'Панама',
        "Папуа-Новая Гвинея"               => 'Папуа-Новая Гвинея',
        "Парагвай"                         => 'Парагвай',
        "Перу"                             => 'Перу',
        "Польша"                           => 'Польша',
        "Португалия"                       => 'Португалия',
        "Пуэрто-Рико"                      => 'Пуэрто-Рико',
        "Республика Конго"                 => 'Республика Конго',
        "Россия"                           => 'Россия',
        "Руанда"                           => 'Руанда',
        "Румыния"                          => 'Румыния',
        "Сальвадор"                        => 'Сальвадор',
        "Сан-Марино"                       => 'Сан-Марино',
        "Саудовская Аравия"                => 'Саудовская Аравия',
        "Свазиленд"                        => 'Свазиленд',
        "Сенегал"                          => 'Сенегал',
        "Сербия"                           => 'Сербия',
        "Сингапур"                         => 'Сингапур',
        "Сирия"                            => 'Сирия',
        "Словакия"                         => 'Словакия',
        "Словения"                         => 'Словения',
        "Соломоновы острова"               => 'Соломоновы острова',
        "Сомали"                           => 'Сомали',
        "Судан"                            => 'Судан',
        "Суринам"                          => 'Суринам',
        "США"                              => 'США',
        "Сьерра-Леоне"                     => 'Сьерра-Леоне',
        "Таджикистан"                      => 'Таджикистан',
        "Таиланд"                          => 'Таиланд',
        "Тайвань"                          => 'Тайвань',
        "Танзания"                         => 'Танзания',
        "Того"                             => 'Того',
        "Тонга"                            => 'Тонга',
        "Тринидад и Тобаго"                => 'Тринидад и Тобаго',
        "Тунис"                            => 'Тунис',
        "Туркменистан"                     => 'Туркменистан',
        "Турция"                           => 'Турция',
        "Уганда"                           => 'Уганда',
        "Узбекистан"                       => 'Узбекистан',
        "Украина"                          => 'Украина',
        "Уругвай"                          => 'Уругвай',
        "Фиджи"                            => 'Фиджи',
        "Филиппины"                        => 'Филиппины',
        "Финляндия"                        => 'Финляндия',
        "Франция"                          => 'Франция',
        "Французская Гвиана"               => 'Французская Гвиана',
        "Хорватия"                         => 'Хорватия',
        "Центральноафриканская Республика" => 'Центральноафриканская Республика',
        "Чад"                              => 'Чад',
        "Чехия"                            => 'Чехия',
        "Чили"                             => 'Чили',
        "Швейцария"                        => 'Швейцария',
        "Швеция"                           => 'Швеция',
        "Шри-Ланка"                        => 'Шри-Ланка',
        "Эквадор"                          => 'Эквадор',
        "Экваториальная Гвинея"            => 'Экваториальная Гвинея',
        "Эритрея"                          => 'Эритрея',
        "Эстония"                          => 'Эстония',
        "Эфиопия"                          => 'Эфиопия',
        "ЮАР"                              => 'ЮАР',
        "Ямайка"                           => 'Ямайка',
        "Япония"                           => 'Япония',
    ];
    public static $townList    = [];

    public static $links = [
        'type'    => [
            '/types/reflector'             => '/category/dizayn_cheloveka/article/2015/09/18/reflektor',
            '/types/manifesting-generator' => '/category/dizayn_cheloveka/article/2015/09/18/manifestiruyuschiy_generator',
            '/types/manifestor'            => '/category/dizayn_cheloveka/article/2015/09/18/manifestor',
            '/types/generator'             => '/category/dizayn_cheloveka/article/2015/09/18/generator',
            '/types/projector'             => '/category/dizayn_cheloveka/article/2015/09/18/proektor',
        ],
        'profile' => [
            '/profiles/profile-1-3' => '/category/dizayn_cheloveka/article/2015/10/11/profil_13_issledovatelmuchenik',
            '/profiles/profile-1-4' => '/category/dizayn_cheloveka/article/2015/10/11/profil_14_issledovatel__opport',
            '/profiles/profile-2-4' => '/category/dizayn_cheloveka/article/2015/10/11/profil_24_otshelnik__opportuni',
            '/profiles/profile-2-5' => '/category/dizayn_cheloveka/article/2015/10/11/profil_25_otshelnik__eretik',
            '/profiles/profile-3-5' => '/category/dizayn_cheloveka/article/2015/10/11/profil_35_muchenik__eretik',
            '/profiles/profile-3-6' => '/category/dizayn_cheloveka/article/2015/10/11/profil_36_muchenik__rolevaya_m',
            '/profiles/profile-4-1' => '/category/dizayn_cheloveka/article/2015/10/11/profil_41_opportunist__issledo',
            '/profiles/profile-4-6' => '/category/dizayn_cheloveka/article/2015/10/11/profil_46_opportunist__rolevay',
            '/profiles/profile-5-1' => '/category/dizayn_cheloveka/article/2015/10/11/profil_51_eretik__issledovatel',
            '/profiles/profile-5-2' => '/category/dizayn_cheloveka/article/2015/10/11/profil_52_eretik__otshelnik',
            '/profiles/profile-6-2' => '/category/dizayn_cheloveka/article/2015/10/11/profil_62_rolevaya_model__otsh',
            '/profiles/profile-6-3' => '/category/dizayn_cheloveka/article/2015/10/11/profil_63_rolevaya_model__much',

        ],
    ];

    /**
     * @param \DateTime $datetime
     * @param string    $country
     * @param string    $town
     *
     * @return \app\models\HumanDesign
     */
    public function calc($datetime, $country, $town)
    {
        $hour = $datetime->format('H');
        if (substr($hour, 0, 1) == '0') $hour = substr($hour, 1);
        $minute = $datetime->format('i');
        if (substr($minute, 0, 1) == '0') $minute = substr($minute, 1);
        $options = [
            'day'        => $datetime->format('j'),
            'month'      => $datetime->format('n'),
            'year'       => $datetime->format('Y'),
            'hour'       => $hour,
            'minute'     => $minute,
            'country_en' => $country,
            'city'       => $town,
        ];
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
        curl_setopt($curl, CURLOPT_POST, 1);
        $query = http_build_query($options);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        $body = curl_exec($curl);

        $result = new \StdClass();
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result->body = $body;
        curl_close($curl);
        $class = new \app\models\HumanDesign($this->getImageUrlFromHtml($result->body));

        return $class;
    }

    /**
     * Получает info дизайна
     *
     * @param $html
     *
     * @return array
     * [
     *    'image' => string
     *    'type' =>
     *        [
     *             'text'
     *             'href'
     *        ]
     *    'profile' =>
     *        [
     *             'text'
     *             'href'
     *        ]
     *    'definition' =>
     *        [
     *             'text'
     *        ]
     *    'inner' =>
     *        [
     *             'text'
     *        ]
     *    'strategy' =>
     *        [
     *             'text'
     *        ]
     *    'theme' =>
     *        [
     *             'text'
     *        ]
     *    'cross' =>
     *        [
     *             'text'
     *        ]
     * ]
     */
    private function getImageUrlFromHtml($html)
    {
        require_once(\Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
        $doc = str_get_html('<root>'.$html.'</root>');
        VarDumper::dump($doc);
        $table = $doc->find('div.uk-panel')[0];
        $img = $doc->find('#imgmap')[0];
        $trList = $table->find('div.uk-grid');
        $row1 = $trList[0]->find('div.uk-width-1-1');
        $row2 = $trList[1]->find('div.uk-width-1-1');
        $row3 = $trList[2]->find('div.uk-width-1-1');
        $Type = $this->getTd($row1[0]);
        $Profile = $this->getTd($row1[1]);
        $Definition = $this->getTd($row1[2]);

        $Inner = $this->getTd($row2[0]);
        $Strategy = $this->getTd($row2[1]);
        $Theme = $this->getTd($row2[2]);
        $Cross = $this->getTd($row3[0]);

        return [
            'image'      => $img->attr['src'],
            'type'       => $Type,
            'profile'    => $Profile,
            'definition' => $Definition,
            'inner'      => $Inner,
            'strategy'   => $Strategy,
            'theme'      => $Theme,
            'cross'      => $Cross,
        ];
    }

    /**
     * @param \simple_html_dom_node $item
     *
     * @return array
     * [
     *    'text'
     *    'href'
     * ]
     */
    private function getTd($item)
    {
        $data = [
            'text' => trim(explode(':', trim($item->plaintext))[1]),
        ];
        $a = $item->find('a');
        if (count($a) > 0) {
            $href = $a[0]->attr['href'];
            $href = str_replace('http://yourhumandesign.ru', '', $href);
            $data['href'] = $href;
        }

        return $data;
    }
} 