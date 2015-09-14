<?php

namespace app\services;

use cs\services\VarDumper;

/**
 * Получает данные для Дизайна Человека
 *
 * Class HumanDesign
 *
 * @package app\services
 *
 */
class HumanDesign2
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

    /**
     * @param \DateTime $datetime
     * @param string    $country
     * @param string    $town
     *
     * @return string
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

        return $this->getImageUrlFromHtml($result->body);
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

        $doc = str_get_html($html);
        $table = $doc->find('table')[0];
        $img = $doc->find('#imgmap')[0];
        $trList = $table->find('tr');
        $row1 = $trList[0]->find('td');
        $row2 = $trList[1]->find('td');
        $row3 = $trList[2]->find('td');
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
        $a = $item->find('A');
        if (count($a) > 0) {
            $data['href'] = $a[0]->attr['href'];
        }

        return $data;
    }
} 