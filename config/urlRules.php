<?php

return [
    'blog/<year:\\d{4}>/<month:\\d{2}>/<day:\\d{2}>/<id:\\w+>'                             => 'page/blog_item',
    'chenneling/<year:\\d{4}>/<month:\\d{2}>/<day:\\d{2}>/<id:\\w+>'                       => 'page/chenneling_item',
    'category/<category:\\w+>/article/<year:\\d{4}>/<month:\\d{2}>/<day:\\d{2}>/<id:\\w+>' => 'page/article',
    'news/<year:\\d{4}>/<month:\\d{2}>/<day:\\d{2}>/<id:\\w+>'                             => 'page/news_item',
    'praktice/<year:\\d{4}>/<month:\\d{2}>/<day:\\d{2}>/<id:\\w+>'                         => 'page/praktice_item',


    'checkBoxTreeMask/add'                                                                 => 'check_box_tree_mask/add',
    'checkBoxTreeMask/addInto'                                                             => 'check_box_tree_mask/add_into',
    'checkBoxTreeMask/delete'                                                              => 'check_box_tree_mask/delete',

    'upload/upload'                                                                        => 'upload/upload',
    'upload/HtmlContent2'                                                                  => 'html_content/upload',

    'password/recover'                                                                     => 'auth/password_recover',
    'password/recover/activate/<code:\\w+>'                                                => 'auth/password_recover_activate',

    'registration'                                                                         => 'auth/registration',
    'registrationActivate/<code:\\w+>'                                                     => 'auth/registration_activate',
    'login'                                                                                => 'auth/login',
    'loginAjax'                                                                            => 'auth/login_ajax',
    'logout'                                                                               => 'auth/logout',
    'auth'                                                                                 => 'auth/auth',

    'direction'                                                                            => 'direction/index',
    'semya'                                                                                => 'direction/semya',

    'category/<id:\\w+>'                                                                   => 'page/category',
    '/'                                                                                    => 'site/index',
    'contact'                                                                              => 'site/contact',
    'clear'                                                                                => 'site/clear',
    'about'                                                                                => 'site/about',
    'captcha'                                                                              => 'site/captcha',
    'log'                                                                                  => 'site/log',
    'logDb'                                                                                => 'site/log_db',
    'siteUpdate'                                                                           => 'site/site_update',
    'siteUpdateAjax'                                                                       => 'site/site_update_ajax',
    'test'                                                                                 => 'site/test',
    'stat'                                                                                 => 'site/statistic',
    'service'                                                                              => 'site/service',
    'thankyou'                                                                             => 'site/thankyou',
    'moneyBack'                                                                            => 'site/money',
    'thank'                                                                                => 'site/thank',
    'logo'                                                                                 => 'site/logo',

    'vasudev'                                                                              => 'busines_club/index',
    'vasudev/login'                                                                        => 'busines_club/login',

    'user/<id:\\d+>'                                                                       => 'site/user',
    'user/<id:\\d+>/rod'                                                                   => 'site/user_rod_list',
    'user/<user_id:\\d+>/rod/<rod_id:\\d+>'                                                => 'site/user_rod',
    'user/<user_id:\\d+>/rod/<rod_id:\\d+>/edit'                                           => 'site/user_rod_edit',

    'subscribe/unsubscribe'                                                                => 'subscribe/unsubscribe',
    'subscribe/mail'                                                                       => 'subscribe/mail',
    'subscribe/activate'                                                                   => 'subscribe/activate',

    'calendar'                                                                             => 'calendar/index',
    'calendar/friends'                                                                     => 'calendar/friends',
    'calendar/friends/vkontakte'                                                           => 'calendar/friends_vkontakte',
    'calendar/save'                                                                        => 'calendar/save',
    'calendar/widget'                                                                      => 'calendar/widget',
    'calendar/cache/show'                                                                  => 'calendar/cache_show',
    'calendar/cache/delete'                                                                => 'calendar/cache_delete',
    'calendar/moon'                                                                        => 'calendar/moon',
    'calendar/colkin'                                                                      => 'calendar/colkin',
    'calendar/colkin/more'                                                                 => 'calendar/colkin_more',
    'calendar/spyral'                                                                      => 'calendar/spyral',
    'calendar/orakul'                                                                      => 'calendar/orakul',
    'calendar/13yasnihZnakov'                                                              => 'calendar/yasnih_znakov',

    'moderator/unionList'                                                                  => 'moderator_unions/index',
    'moderator/unionList/<id:\\d+>/accept'                                                 => 'moderator_unions/accept',
    'moderator/unionList/<id:\\d+>/reject'                                                 => 'moderator_unions/reject',
    'moderator/unionList/<id:\\d+>/delete'                                                 => 'moderator_unions/delete',

    'admin/pictures'                                                                       => 'admin_pictures/index',
    'admin/pictures/add'                                                                   => 'admin_pictures/add',
    'admin/pictures/<id:\\d+>'                                                             => 'admin_pictures/view',

    'admin/subscribe'                                                                      => 'admin_subscribe/index',
    'admin/subscribe/add'                                                                  => 'admin_subscribe/add',
    'admin/subscribe/send'                                                                 => 'admin_subscribe/send',
    'admin/subscribe/delete'                                                               => 'admin_subscribe/delete',
    'admin/subscribe/add/simple'                                                           => 'admin_subscribe/add_simple',
    'admin/subscribe/<id:\\d+>'                                                            => 'admin_subscribe/view',
    'admin/subscribe/<id:\\d+>/edit'                                                       => 'admin_subscribe/edit',

    'admin/serviceList'                                                                    => 'admin_service/index',
    'admin/serviceList/add'                                                                => 'admin_service/add',
    'admin/serviceList/<id:\\d+>/delete'                                                   => 'admin_service/delete',
    'admin/serviceList/<id:\\d+>/edit'                                                     => 'admin_service/edit',
    'admin/serviceList/<id:\\d+>/subscribe'                                                => 'admin_service/subscribe',

    'admin/smeta'                                                                          => 'admin_smeta/index',
    'admin/smeta/add'                                                                      => 'admin_smeta/add',
    'admin/smeta/<id:\\d+>/delete'                                                         => 'admin_smeta/delete',
    'admin/smeta/<id:\\d+>/edit'                                                           => 'admin_smeta/edit',

    'admin/news'                                                                           => 'admin/news',
    'admin/news/add'                                                                       => 'admin/news_add',
    'admin/news/<id:\\d+>/delete'                                                          => 'admin/news_delete',
    'admin/news/<id:\\d+>/edit'                                                            => 'admin/news_edit',
    'admin/news/<id:\\d+>/subscribe'                                                       => 'admin/news_subscribe',

    'admin/events'                                                                         => 'admin_events/index',
    'admin/events/add'                                                                     => 'admin_events/add',
    'admin/events/<id:\\d+>/delete'                                                        => 'admin_events/delete',
    'admin/events/<id:\\d+>/edit'                                                          => 'admin_events/edit',
    'admin/events/<id:\\d+>/subscribe'                                                     => 'admin_events/subscribe',

    'admin/praktice'                                                                       => 'admin_praktice/index',
    'admin/praktice/add'                                                                   => 'admin_praktice/add',
    'admin/praktice/<id:\\d+>/delete'                                                      => 'admin_praktice/delete',
    'admin/praktice/<id:\\d+>/edit'                                                        => 'admin_praktice/edit',

    'admin/blog'                                                                           => 'admin_blog/index',
    'admin/blog/add'                                                                       => 'admin_blog/add',
    'admin/blog/<id:\\d+>/delete'                                                          => 'admin_blog/delete',
    'admin/blog/<id:\\d+>/edit'                                                            => 'admin_blog/edit',
    'admin/blog/<id:\\d+>/subscribe'                                                       => 'admin_blog/subscribe',

    'admin/chennelingList'                                                                 => 'admin/chenneling_list',
    'admin/chennelingList/add'                                                             => 'admin/chenneling_list_add',
    'admin/chennelingList/addFromPage'                                                     => 'admin/chenneling_list_add_from_page',
    'admin/chennelingList/<id:\\d+>/delete'                                                => 'admin/chenneling_list_delete',
    'admin/chennelingList/<id:\\d+>/edit'                                                  => 'admin/chenneling_list_edit',
    'admin/chennelingList/<id:\\d+>/subscribe'                                             => 'admin/chenneling_list_subscribe',
    'admin/articleList'                                                                    => 'admin_article/index',
    'admin/articleList/add'                                                                => 'admin_article/add',
    'admin/articleList/addFromPage'                                                        => 'admin_article/add_from_page',
    'admin/articleList/<id:\\d+>/delete'                                                   => 'admin_article/delete',
    'admin/articleList/<id:\\d+>/edit'                                                     => 'admin_article/edit',
    'admin/articleList/<id:\\d+>/subscribe'                                                => 'admin_article/subscribe',
    'admin/categoryList'                                                                   => 'admin_category/index',
    'admin/categoryList/add'                                                               => 'admin_category/add',
    'admin/categoryList/<id:\\d+>/delete'                                                  => 'admin_category/delete',
    'admin/categoryList/<id:\\d+>/edit'                                                    => 'admin_category/edit',
    'admin/investigator'                                                                   => 'admin_investigator/index',

    'cabinet/officeList/<unionId:\\d+>'                                                    => 'cabinet_office/index',
    'cabinet/officeList/<unionId:\\d+>/add'                                                => 'cabinet_office/add',
    'cabinet/officeList/<id:\\d+>/delete'                                                  => 'cabinet_office/delete',
    'cabinet/officeList/<id:\\d+>/edit'                                                    => 'cabinet_office/edit',

    // магазин
    'shop'                                                                                 => 'shop/index',
    'cabinet/shop/<id:\\d+>'                                                               => 'cabinet_shop/index',
    'cabinet/shop/<id:\\d+>/productList'                                                   => 'cabinet_shop/product_list',
    'cabinet/shop/<id:\\d+>/productList/add'                                               => 'cabinet_shop/product_list_add',

    'admin/checkBoxTreeMask/add'                                                           => 'admin_check_box_tree_mask/add',
    'admin/checkBoxTreeMask/addInto'                                                       => 'admin_check_box_tree_mask/add_into',
    'admin/checkBoxTreeMask/delete'                                                        => 'admin_check_box_tree_mask/delete',


    'praktice'                                                                             => 'page/praktice',
    'house'                                                                                => 'page/house',
    'mission'                                                                              => 'page/mission',
    'medical'                                                                              => 'page/medical',
    'up'                                                                                   => 'page/up',
    'study'                                                                                => 'page/study',
    'study/add'                                                                            => 'page_add/study',
    'time'                                                                                 => 'page/time',
    'time/arii'                                                                            => 'page/time_arii',
    'language'                                                                             => 'page/language',
    'language/article/<id:\\w+>'                                                           => 'page/language_article',
    'energy'                                                                               => 'page/energy',
    'money'                                                                                => 'page/money',
    'food'                                                                                 => 'page/food',
    'food/<id:\\d+>'                                                                       => 'page/food_item',
    'category/<category:\\w+>/<id:\\d+>'                                                   => 'page/union_item',
    'forgive'                                                                              => 'page/forgive',
    'tv'                                                                                   => 'page/tv',
    'blog'                                                                                 => 'page/blog',

    'newEarth'                                                                             => 'new_earth/index',
    'newEarth/price'                                                                       => 'new_earth/price',
    'newEarth/kon'                                                                         => 'new_earth/kon',
    'newEarth/chakri'                                                                      => 'new_earth/chakri',
    'newEarth/civilizations'                                                               => 'new_earth/civilizations',
    'newEarth/civilizations/<name:\\w+>'                                                   => 'new_earth/civilizations_item',
    'declaration'                                                                          => 'new_earth/declaration',
    'residence'                                                                            => 'new_earth/residence',
    'manifest'                                                                             => 'new_earth/manifest',
    'history'                                                                              => 'new_earth/history',
    'pledge'                                                                               => 'new_earth/pledge',
    'program'                                                                              => 'new_earth/program',
    'hymn'                                                                                 => 'new_earth/hymn',
    'codex'                                                                                => 'new_earth/codex',

    'events'                                                                               => 'calendar/events',
    'events/<id:\\d+>'                                                                     => 'calendar/events_item',

    'clothes'                                                                              => 'page/clothes',
    'portals'                                                                              => 'page/portals',
    'arts'                                                                                 => 'page/arts',
    'idea'                                                                                 => 'page/idea',
    'music'                                                                                => 'page/music',
    'news'                                                                                 => 'page/news',
    'chenneling'                                                                           => 'page/chenneling',
    'chenneling/search'                                                                    => 'page/chenneling_search',
    'chenneling/search_ajax'                                                               => 'page/chenneling_search_ajax',
    'chenneling/ajax'                                                                      => 'page/chenneling_ajax',
    'services'                                                                             => 'page/services',
    'services/<id:\\d+>'                                                                   => 'page/services_item',
    'page/<action>'                                                                        => 'page/<action>',

    'comment/send'                                                                         => 'comment/send',


    'objects'                                                                              => 'cabinet/objects',
    'objects/<id:\\d+>/edit'                                                               => 'cabinet/objects_edit',
    'objects/add'                                                                          => 'cabinet/objects_add',
    'objects/<id:\\d+>/delete'                                                             => 'cabinet/objects_delete',
    'objects/<id:\\d+>/subscribe'                                                          => 'cabinet/objects_subscribe',
    'objects/<id:\\d+>/sendModeration'                                                     => 'cabinet/send_moderation',
    'cabinet/passwordChange'                                                               => 'cabinet/password_change',
    'cabinet/profile'                                                                      => 'cabinet/profile',
    'cabinet/profile/humanDesign'                                                          => 'cabinet/profile_human_design',
    'cabinet/profile/humanDesign/ajax'                                                     => 'cabinet/profile_human_design_ajax',
    'cabinet/profile/humanDesign/delete'                                                   => 'cabinet/profile_human_design_delete',
    'cabinet/profile/unLinkSocialNetWork'                                                  => 'cabinet/profile_unlink_social_network',
    'cabinet/profile/zvezdnoe'                                                             => 'cabinet/profile_zvezdnoe',
    'cabinet/profile/time'                                                                 => 'cabinet/profile_time',
    'cabinet/profile/subscribe'                                                            => 'cabinet/profile_subscribe',
    'cabinet/mindMap'                                                                      => 'cabinet/mind_map',
    'cabinet/poseleniya'                                                                   => 'cabinet/poseleniya',
    'cabinet/poseleniya/add'                                                               => 'cabinet/poseleniya_add',
    'cabinet/poseleniya/<id:\\d+>/edit'                                                    => 'cabinet/poseleniya_edit',
    'cabinet/poseleniya/<id:\\d+>/delete'                                                  => 'cabinet/poseleniya_delete',
];