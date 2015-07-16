<?php


namespace cs\models\Calendar;

use cs\services\VarDumper;
use DateTime;
use DateTimeZone;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use app\services\calendar\maya\Driver2;

class Maya
{
    const COLOR_RED    = 1;
    const COLOR_WHITE  = 2;
    const COLOR_BLUE   = 3;
    const COLOR_YELLOW = 4;

    /**
     * @var array $tonList список тонов
     * http://yamaya.ru/maya/ton/
     */
    public static $tonList = [
        1  => ['Магнитный тон цели', 'хун',],
        2  => ['Лунный тон принятия вызова', 'ка',],
        3  => ['Электрический тон служения', 'ош',],
        4  => ['Самосущный тон формы', 'кан',],
        5  => ['Обертонный тон сияния', 'хо',],
        6  => ['Ритмический тон равенства', 'уак',],
        7  => ['Резонансный тон сонастройки', 'ук',],
        8  => ['Галактический тон целостности', 'уашак',],
        9  => ['Солнечный тон намерения', 'болон',],
        10 => ['Планетарный тон проявленности', 'лахун',],
        11 => ['Спектральный тон освобождения', 'хунлахун',],
        12 => ['Кристаллический тон сотрудничества', 'калахун',],
        13 => ['Космический тон присутствия', 'ошлахун',],
    ];

    public static $stampRows = [
        [
            "Красный дракон",
            "ИМИШ",
            "Питание. Рождение. Бытие. Память.",
            "Откройся энергиям Рождения и Упования, высшей веры во всемогущество бытия, и пусть они выражают себя в твоей жизни. Фокусируйся как на самостоятельности, так и на благодарном принятии необходимого питания от Вселенной. Только так жизнь поможет тебе осуществить твои глубинные потребности. Позволь энергии рождения инициировать и претворять в жизнь все твои начинания!",
            "Восток — инициирует.",
            "Горловая чакра.",
            "Указательный палец правой руки.",
            "Я питаю рождение моего бытия первозданным доверием."
        ],
        [
            "Белый ветер",
            "ИК",
            "Коммуникации и связи. Дух. Дыхание.",
            "Получай и выражай энергии Духа и Связности. Фокусируйся на присутствии Духа во всех твоих делах. Будь созвучен со своим естественным вдохновением! Пусть Дух поможет тебе выражать сокровенную Истину твоего бытия! Движение Духа — это всемогущее Дыхание самого бытия, объединяющего всех и вся.",
            "Север — очищает.",
            "Сердечная чакра.",
            "Средний палец правой руки.",
            "Дыша вдохновением, Я строю спираль созидания."
        ],
        [
            "Синяя ночь",
            "АКБАЛЬ",
            "Мечты и сновидения. Изобилие. Интуиция.",
            "Принимай и выражай энергии Сновидения и Изобилия. Войди в святилище своего сердца, в его сокровенную тьму — арену твоих внутренних мистерий. Стань единым со своим нерушимым покоем и интуицией. Настраивайся на естественное изобилие, окружающее тебя, и мечтай!",
            "Запад — трансформирует.",
            "Чакра солнечного сплетения.",
            "Безымянный палец правой руки.",
            "Интуиция открывает мне двери мечты в святилище Изобилия."
        ],
        [
            "Жёлтое семя",
            "КАН",
            "Целеустремлённость. Цветение. Осознание.",
            "Получай и выражай силы Осознанности и Цветения. Фокусируйся на всемогуществе твоих намерений. Нацеливай свои желания, и тогда они осуществятся. Высаживай семена сущностно важных явлений с предельной точностью. Питай и взращивай их, наблюдая за их разрастанием. Ощущай себя живым цветком! ",
            "Юг — расширяет.",
            "Корневая чакра (копчик).",
            "Мизинец правой руки.",
            "Моя осознанность даёт возможность расцвести семенам Творения."
        ],
        [
            "Красный змей",
            "ЧИК-ЧАН",
            "Жизнестойкость. Жизненная сила. Инстинкт. Сексуальность.",
            "Получай и выражай силы Жизненности и Инстинкта. Вслушивайся в первозданную мудрость своего физического храма и чти его совершенство. Настраивайся на свою страстность, жизненность, чувственность и сексуальность. Чувствуй, как пробуждается и расцветает твоя кундалини!",
            "Восток — инициирует.",
            "Коронная чакра (макушка).",
            "Большой палец правой ноги.",
            "Основа моей жизненной силы — инстинкт моей страсти."
        ],
        [
            "Белый cоединитель миров",
            "КИМИ",
            "Выравнивание. Смерть. Благоприятная возможность.",
            "Получай и выражай силу Смерти и Самоотдачи. Фокусируйся на том, чтобы позволить произойти неизбежным смертям и разлукам. Так ты откроешь врата обновлению и новым благоприятным возможностям. Отпускай и прощай! Бери под контроль побуждения своей низшей природы, чтобы ощутить Благодать Божественного Плана! Перекидывать мостики между мирами тебе поможет сила уравновешенности и непредвзятости. ",
            "Север — очищает.",
            "Горловая чакра. ",
            "Второй палец правой ноги.",
            "Я покорен своей благоприятной возможности."
        ],
        [
            "Синяя рука",
            "МАНИК",
            "Знание. Свершение. Исцеление.",
            "Получай и выражай силы Свершения и Целения. Наполняй свою жизнь Свершением, в самом глубинном смысле этого слова. Исцеляй все уровни человеческого бытия! Оттачивай мастерство привносить в свою жизнь то, что желанно тебе. Приводи к совершенству и завершению те сферы своей жизни, которые помогут тебе выйти на следующий, неизведанный уровень бытия. ",
            "Запад — трансформирует.",
            "Сердечная чакра.",
            "Средний палец правой ноги.",
            "Я здесь, чтобы свершить исцеление Планеты."
        ],
        [
            "Жёлтая звезда",
            "ЛАМАТ",
            "Творчество. Изящество. Искусство.",
            "Получай и выражай силы Красоты и Изящества. Фокусируйся на вхождении в поток высшей утончённости, естественной лёгкости, текучести и покоя. Участвуй в создании и распространении гармонии в мире! Освободись от всякого самоосуждения и пойми, что твоя жизнь — произведение искусства!",
            "Юг — расширяет.",
            "Чакра солнечного сплетения.",
            "Безымянный палец правой ноги.",
            "Я пробуждена к красоте, дышу изяществом и излучаю искусство."
        ],
        [
            "Красная луна",
            "МУЛУК",
            "Очищение. Поток. Вселенская Вода.",
            "Получай и выражай силу Вселенского Потока Очищения. Фокусируйся на очистке инструмента своего восприятия - единства тела и разума. Это возможно благодаря его постоянной взаимосвязи с Высшим “Я”. Питай своё тело, основу своего мира, вибрациями собственной цельности. Воссоединение с самим собой ведёт к полной пробуждённости в каждый миг твоей жизни. Пробудив в себе текучесть и гибкость, ты позволишь событиям в полном смысле проистекать!",
            "Восток — инициирует.",
            "Корневая чакра.",
            "Мизинец правой ноги.",
            "Я Есмь поток очищения, влившийся в многомерность моего существа."
        ],
        [
            "Белая собака",
            "ОК",
            "Любовь. Сердце. Преданность.",
            "Получай и выражай силы Любви и Преданности. Фокусируйся на преодолении ограничивающих комплексов в эмоциональной сфере, активируя свою духовную силу и стремление к взаимодействию. Настраивайся на Единое Сердце Вселенной! Ищи новые уровни воссоединения со своими спутниками на жизненном пути! Будь предан сокровенной истине твоего существа, своего пути и предназначения. ",
            "Север — очищает.",
            "Коронная чакра. ",
            "Большой палец левой руки.",
            "Единое сердце, любовь и преданность — спутники моей судьбы."
        ],
        [
            "Синяя обезьяна",
            "ЧУЭН",
            "Игра. Магия. Иллюзия.",
            "Получай и выражай силу Магии и Игры. Фокусируйся на том, что твоя жизнь — праздник твоего божественного внутреннего ребёнка, природа которого — невинность, игра и спонтанность. Смейся над самим собой, растворяя всякую напыщенность и серьёзность! Наслаждайся своей невесомостью и многоцветием иллюзий! Юмор и смех помогут тебе стать неуязвимым.",
            "Запад — трансформирует.",
            "Горловая чакра.",
            "Указательный палец левой руки.",
            "Моя игра — магия моей первозданной невинности."
        ],
        [
            "Жёлтый человек",
            "ЭБ",
            "Влияние. Свободная воля. Мудрость.",
            "Получай и выражай силу Свободной Воли и Влияния. Настраивай свою свободную волю на целостность и самоуважение. Пробуждай способности, дремлющие в твоей человеческой форме, становясь созвучным с высшей, сияющей мудростью. Ощущай и выражай свою открытость ко всему человечеству! Чти мудрость спутников, идущих с тобой по жизненному пути.",
            "Юг — расширяет.",
            "Сердечная чакра.",
            "Средний палец левой руки.",
            "Я пожинаю урожай мудрости моей свободной воли."
        ],
        [
            "Красный небесный странник",
            "БЭН",
            "Исследование. Пространство. Пробуждённость. Пророчество.",
            "Получай и выражай силу Пророчества и Пробуждённости. Активно участвуй в возрождении Земли согласно Пророчеству. Помогай ей возвратиться в её первозданное состояние райского сада! Неси миру священную весть о воссоединении Небес и Земли! Смело входя в неизведанное, помни, что твоя сила — в непривязанности к точкам отсчёта. Растворяй устоявшиеся мнения о себе! Исследуй внешнее и внутреннее пространство! ",
            "Восток — инициирует.",
            "Чакра Солнечного Сплетения. ",
            "Безымянный палец левой руки.",
            "В полной пробуждённости Я исследую неизвестное."
        ],
        [
            "Белый волшебник",
            "ИШ",
            "Вневременность. Восприимчивость. Чарование.",
            "Получай и выражай силу Вневременности и Чарования. Открывай в себе восприимчивость радиальной природы времени - вечного “Сейчас”! Твоё сердце — врата Божественного Чарования. Стань мудрецом, прозрачным для всего спектра энергий, и магия жизни будет свободно твориться через тебя. ",
            "Север — очищает.",
            "Корневая чакра (копчик).",
            "Мизинец левой руки.",
            "Чары вневременности источаются моим восприимчивым сердцем."
        ],
        [
            "Синий орёл",
            "МЭН",
            "Творчество. Видение. Разум.",
            "Получай и выражай силы Видения и Разума. Сосредоточенность на созерцании Великого Плана поможет тебе воспарить, подобно орлу! Пусть твоё зрение будет ясным и острым! Творя силой разума, ты обретёшь вдохновение в преданности своему видению. Укрепляй своё взаимодействие с Планетарным Разумом! ",
            "Запад — трансформирует.",
            "Коронная чакра.",
            "Большой палец левой ноги.",
            "Я предан своему видению Планетарного Разума."
        ],
        [
            "Жёлтый воин",
            "КИБ",
            "Интеллект. Бесстрашие. Непредвзятое исследование.",
            "Получай и выражай силы Бесстрашия и Интеллекта. Внимай своему внутреннему голосу, идя по тропе Космических Вех — от Оспаривания к Несомненности. Смело иди навстречу своим страхам! Ничему слепо не верь и исследуй явления жизни с помощью Божественного Интеллекта. Стань истинным Воином Благодати! ",
            "Юг — расширяет.",
            "Горловая чакра.",
            "Второй палец левой ноги.",
            "Я Есмь Воин света со щитом интеллекта и мечом сострадания."
        ],
        [
            "Красная земля",
            "КАБАН",
            "Эволюция. Навигация. Синхронность.",
            "Получай и выражай силу Навигации и Развития. Курс твоей пространственно-временной реальности одухотворяется синхронностью с твоей высшей тропой. Смело отмыкай врата Эволюции. Относись к нашей планете с любовью; чти и воспевай её первозданную святость.",
            "Восток — инициирует.",
            "Сердечная чакра.",
            "Средний палец левой ноги.",
            "Я прокладываю курс моей Планеты в синхронности с галактической Эволюцией."
        ],
        [
            "Белое зеркало",
            "ЭЦНАБ",
            "Отражение. Бесконечность. Упорядоченность. Медитация.",
            "Получай и выражай силы Отражения и Бесконечности. Стань зеркалом, отражающим свет Божественного Миропорядка. Учись видеть свои отражения в зеркалах людей и событий, отличая истинное от иллюзорного. Встречаясь лицом к лицу со своими теневыми сторонами, отпускай от себя всё, что отражает тебя искажённо. Откройся восприятию опыта бесконечности! ",
            "Север — очищает.",
            "Чакра Солнечного Сплетения.",
            "Безымянный палец левой ноги.",
            "Я созерцаю бесконечные отражения Божественного."
        ],
        [
            "Синяя буря",
            "КАУАК",
            "Ускорение всех процессов. Самопорождение. Энергизация.",
            "Получай и выражай силу Самопорождающей Энергии. Высвобождая её, ты пробуждаешь своего внутреннего Громовержца! Ускоряй процессы преображения и инициируй очищение своей жизни! Самопорождение собственного освобождения — вполне в твоих силах. ",
            "Запад — трансформирует.",
            "Корневая чакра.",
            "Мизинец левой ноги.",
            "Я несу в себе самопорождение свободы моей энергии и энергии моей свободы."
        ],
        [
            "Жёлтое солнце",
            "АХАУ",
            "Просветление. Вселенский Огонь. Вознесение. Жизнь.",
            "Получай и выражай силы Вознесения и Просветления. Твоя цель — вознесение силой Вселенского Огня Просветления! Сияние твоего внутреннего солнца озаряет и насыщает энергией каждый момент твоей жизни. Тебе раскрывается осознание своей цельности и свободы. Наслаждайся опытом целостного восприятия матрицы жизни через линзу необусловленной любви.",
            "Юг — расширяет.",
            "Коронная чакра.",
            "Большой палец правой руки.",
            "Я Есмь Вселенский Огонь — горючее для вознесения моей Планеты."
        ]
    ];

    /**
     * @var array $plazmaRows
     *
     * http://yamaya.ru/maya/plasma/
     */
    public static $plazmaRows = [
        1 => [
            'name'        => 'Дали',
            'description' => 'Нацеливает тепловую силу. Мой Отец - внутреннее осознание. Я чувствую тепло.',
        ],
        2 => [
            'name'        => 'Сели',
            'description' => 'Проводит силу света. Моя Мать - изначальная сфера. Я вижу свет!',
        ],
        3 => [
            'name'        => 'Гамма',
            'description' => 'Умиротворяет свето-тепловую ударную силу. Мое происхождение - союз внутреннего осознания и изначальной сферы. Я обретаю силу Мира!',
        ],
        4 => [
            'name'        => 'Кали',
            'description' => '',
        ],
        5 => [
            'name'        => 'Альфа',
            'description' => '',
        ],
        6 => [
            'name'        => 'Лими',
            'description' => '',
        ],
        7 => [
            'name'        => 'Силио',
            'description' => '',
        ],
    ];

    public static $portalList = [1, 22, 43, 64, 85, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 96, 77, 58, 39, 20, 88, 69, 50, 51, 72, 93,
        241, 222, 203, 184, 165, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 176, 197, 218, 239, 260, 168, 189, 210, 211, 192, 173
    ];


    /**
     * @param string|int|DateTime $date UTC
     *
     * @return DateTime
     */
    private static function convertDate($date)
    {
        if (is_string($date)) {
            return new DateTime($date, new DateTimeZone('UTC'));
        } else if ($date instanceof DateTime) {
            return $date;
        } else if (is_integer($date)) {
            return new DateTime('@' . $date);
        } else {
            return new DateTime();
        }
    }

    /**
     * Расчитывает кин
     *
     * @param DateTime $date
     *
     * @return int
     */
    public static function calcKin($date)
    {
        return Driver2::calc($date);
    }

    /**
     * @param DateTime $date
     *
     * @return int
     */
    public static function calcKin1($date)
    {
        $date->setTimezone(new DateTimeZone('Europe/Moscow'));
        $d = $date->format('j');
        $mo = $date->format('n');
        $ye = $date->format('Y');
        $g62 = 0;
        $date_d = (int)($d);
        $date_m = (int)($mo);
        $date_mm = $date_m;
        $date_y = (int)($ye);
        $date_z = -1;
        $years = [9, 114, 219, 64, 169, 14, 119, 224, 69, 174, 19, 124, 229, 74, 179, 24, 129, 234, 79, 184, 29, 134, 239, 84, 189, 34, 139, 244, 89, 194, 39, 144, 249, 94, 199, 44, 149, 254, 99, 204, 49, 154, 259, 104, 209, 54, 159, 4, 109, 214, 59, 164];
        $day = 207;
        $y = $date_y - 1910;
        if ($y > 52) {
            $y = $y % 52;
        } else if ($y == 52) {
            $g62 = 1;
            $y = 1;
        }
        $ee = 0;
        $ydel4 = $y / 4;
        $ydel4int = (int)($ydel4);
        if ($ydel4 == $ydel4int) {
            $ee = 1;
            $day = 208;
        }
        switch ($date_mm) {
            case 1:
                $date_m = -102;
                break;
            case 2:
                $date_m = -71;
                $date_z = $date_z + 31;
                break;
            case 3:
                $date_m = -43;
                $date_z = $date_z + 59 + $ee;
                break;
            case 4:
                $date_m = -12;
                $date_z = $date_z + 90 + $ee;
                break;
            case 5:
                $date_m = 18;
                $date_z = $date_z + 120 + $ee;
                break;
            case 6:
                $date_m = 49;
                $date_z = $date_z + 151 + $ee;
                break;
            case 7:
                $date_z = $date_z + 181 + $ee;
                break;
            case 8:
                $date_m = 5;
                $date_z = $date_z + 212 + $ee;
                break;
            case 9:
                $date_m = 36;
                $date_z = $date_z + 243 + $ee;
                break;
            case 10:
                $date_m = 66;
                $date_m = 66;
                $date_z = $date_z + 273 + $ee;
                break;
            case 11:
                $date_m = 97;
                $date_z = $date_z + 304 + $ee;
                break;
            case 12:
                $date_m = 127;
                $date_z = $date_z + 334 + $ee;
                break;
        }
        if ($date_m == 7) {
            switch ($date_d) {
                case 25:
                    $date_m = 104;
                    break;
                case 26:
                    $date_m = 0;
                    break;
                case 27:
                    $date_m = 1;
                    break;
                case 28:
                    $date_m = 2;
                    break;
                case 29:
                    $date_m = 3;
                    break;
                case 30:
                    $date_m = 4;
                    break;
                case 31:
                    $date_m = 5;
                    break;
                default:
                    $date_m = 79;
            }
        }
        $date_z = $date_z + $date_d;
        if ($g62 == 1) {
            if ($date_z <= $day) {
                $y = 51;
            } else {
                $y = 0;
            }
        } else if ($date_z <= $day) {
            $y = $y - 1;
        }
        $ch_y = $years[ $y ];
        $kin = $ch_y + $date_m + $date_d;
        if ($kin > 260) {
            $kin = $kin - 260;
        }
        if ($kin <= 0) {
            $kin = $kin + 260;
        }

        return $kin;
    }

    /**
     * @param string|int|DateTime $date
     *
     * @return array
     */
    public static function calc($date = null)
    {
        if (is_null($date)) $date = time();
        $date = self::convertDate($date);

        $kin = self::calcKin($date);
        $ton = $kin % 13;
        if ($ton == 0) {
            $ton = 13;
        }
        $stamp = $kin % 20;
        if ($stamp == 0) {
            $stamp = 20;
        }

        return [
            'ton'        => $ton,
            'kin'        => $kin,
            'stamp'      => $stamp,
            'nearPortal' => self::nearPortal($kin)
        ];
    }

    /**
     * Возвращает сколько дней осталось до ближайшего ПГА
     * если 0 значит сегодня ПГА
     *
     * @param int $kin 1-260
     *
     * @return int|null
     */
    private static function nearPortal($kin)
    {
        sort(self::$portalList);
        $arr = self::$portalList;
        $count = count($arr) - 1;
        for ($i = 0; $i < $count; $i++) {
            $item = $arr[ $i ];
            if ($item == $kin) return 0;
            if ($item < $kin && $arr[ $i + 1 ] > $kin) {
                return $arr[ $i + 1 ] - $kin;
            }
        }

        return null;
    }


    /**
     * Возвращает дни цолькина в виде двумерного массива
     *
     * @param string|int|DateTime $date дата попадающая в цолькин
     *                              если строка то в формате 'yyyy-mm-dd'
     *                              Если параметр не передан то считается что расчет ведется на текущую дату
     *
     * @return array
     * двумерный массив [строка от 1][колонка от 1]
     * [
     * 'ton' => int от 1
     * 'kin' => int от 1
     * 'stamp' => int от 1
     * 'isPortal' => bool
     * 'day' => int
     * 'month' => int
     * 'year' => int
     * 'date' => 'yyyy-mm-dd'
     * ]
     *
     * @throws \yii\base\Exception
     */
    public static function colkin($date = null)
    {
        $days = [];
        $todayGrisha = null;
        if (is_null($date)) {
            $todayGrisha = new DateTime();
        } else {
            $todayGrisha = self::convertDate($date);
        }
        $today = self::calc($todayGrisha);
        if ($today['kin'] > 1) {
            $add = $today['kin'] - 1;
            $interval = new \DateInterval("P{$add}D");
            $interval->invert = 1;
            $todayGrisha->add($interval);
        }

        $ton = 1;
        $stamp = 1;
        for ($kin = 1; $kin <= 260; $kin++) {
            $col = ((int)(($kin - 1) / 20)) + 1;
            $row = $kin % 20;
            if ($row == 0) $row = 20;
            $days[ $row ][ $col ] = [
                'ton'      => $ton,
                'kin'      => $kin,
                'stamp'    => $stamp,
                'isPortal' => in_array($kin, Maya::$portalList),
                'isToday'  => ($todayGrisha->format('Y-m-d') == (new DateTime())->format('Y-m-d'))? 1:0,
                'day'      => $todayGrisha->format('j'),
                'month'    => $todayGrisha->format('n'),
                'year'     => $todayGrisha->format('Y'),
                'date'     => $todayGrisha->format('Y-m-d'),
            ];
            $todayGrisha->add(new \DateInterval("P1D"));
            if ($days[ $row ][ $col ]['month'] == 2) {
                if ($days[ $row ][ $col ]['day'] == 29) {
                    $todayGrisha->add(new \DateInterval("P1D"));
                }
            }
            $stamp++;
            $ton++;
            if ($stamp > 20) $stamp = 1;
            if ($ton > 13) $ton = 1;
        }

        return $days;
    }

    /**
     * Возвращает дни года
     *
     * @param string|int|DateTime $date дата попадающая в цолькин
     *                              если строка то в формате 'yyyy-mm-dd'
     *                              Если параметр не передан то считается что расчет ведется на текущую дату
     *
     * @return array
     * [
     *      'monthList' => [месяц(луна) от 1 до 13][неделя от 1 до 4][день от 1 до 7]
     *                   [
     *                   'ton' => int от 1
     *                   'kin' => int от 1
     *                   'stamp' => int от 1
     *                   'isPortal' => bool
     *                   'day' => int
     *                   'month' => int
     *                   'year' => int
     *                   'date' => 'yyyy-mm-dd'
     *                   'isToday' => true - не обязательное поле
     *                   ]
     *      'dayOutOfTime' =>
     *                   [
     *                   'ton' => int от 1
     *                   'kin' => int от 1
     *                   'stamp' => int от 1
     *                   'isPortal' => bool
     *                   'day' => int
     *                   'month' => int
     *                   'year' => int
     *                   'date' => 'yyyy-mm-dd'
     *                   'isToday' => true - не обязательное поле
     *                   ]
     * ]
     *
     * @throws \yii\base\Exception
     */
    public static function getYear($date = null)
    {
        $todayGrisha = null;
        if (is_null($date)) {
            $todayGrisha = new DateTime();
        } else {
            $todayGrisha = self::convertDate($date);
        }
        // вычисляю начало года
        $startGrisha = self::getYearGetStart($todayGrisha);
        $todayGrishaString = $todayGrisha->format('Y-m-d');
        $kin = self::calcKin($startGrisha);
        $ton = $kin % 13;
        if ($ton == 0) $ton = 13;
        $stamp = $kin % 20;
        if ($stamp == 0) $stamp = 20;
        $monthList = [];
        $dateGrisha = $startGrisha;
        for($moon = 1; $moon <= 13; $moon++) {
            for($week = 1; $week <=4; $week++) {
                for($day = 1; $day <= 7; $day++) {
                    $thisDateGrishaString = $dateGrisha->format('Y-m-d');
                    $monthList[ $moon ][ $week ][ $day ] = [
                        'ton'      => $ton,
                        'kin'      => $kin,
                        'stamp'    => $stamp,
                        'isPortal' => in_array($kin, self::$portalList),
                        'day'      => $dateGrisha->format('j'),
                        'month'    => $dateGrisha->format('n'),
                        'year'     => $dateGrisha->format('Y'),
                        'date'     => $thisDateGrishaString,
                        'isToday'  => ($thisDateGrishaString == $todayGrishaString),
                    ];
                    $dateGrisha->add(new \DateInterval('P1D'));
                    if ($dateGrisha->format('n') == 2) {
                        if ($dateGrisha->format('d') == 29) {
                            $dateGrisha->add(new \DateInterval('P1D'));
                        }
                    }
                    $kin++;
                    if ($kin > 260) $kin = 1;
                    $ton++;
                    if ($ton == 14) $ton = 1;
                    $stamp = $kin % 20;
                    if ($stamp == 0) $stamp = 20;
                }
            }
        }

        $thisDateGrishaString = $dateGrisha->format('Y-m-d');
        $dayOutOfTime = [
            'ton'      => $ton,
            'kin'      => $kin,
            'stamp'    => $stamp,
            'isPortal' => in_array($kin, self::$portalList),
            'day'      => $dateGrisha->format('j'),
            'month'    => $dateGrisha->format('n'),
            'year'     => $dateGrisha->format('Y'),
            'date'     => $thisDateGrishaString,
            'isToday'  => ($thisDateGrishaString == $todayGrishaString),
        ];

        return [
            'monthList'    => $monthList,
            'dayOutOfTime' => $dayOutOfTime,
        ];
    }

    /**
     * Возвращает дату начала года
     * Если дата < 26.07 то будет возвращет прошлый год иначе этот год
     *
     * @param DateTime $date
     *
     * @return DateTime
     */
    public static function getYearGetStart($date)
    {
        if ($date->format('j') != 26 or $date->format('n') != 7) {
            if (($date->format('n') < 7) or ($date->format('n') == 7 and $date->format('j') < 26)) {
                return new DateTime(($date->format('Y') - 1) . '-07-26');
            } else {
                return new DateTime($date->format('Y') . '-07-26');
            }
        }
        return $date;
    }
}