{use class="cs\models\Bank"}
{use class="yii\widgets\ActiveForm"}
{use class="yii\helpers\Html"}
{use class="yii\captcha\Captcha"}
{use class="yii\helpers\ArrayHelper"}
{use class="yii\grid\GridView"}
{use class="app\models\User"}
{use class="cs\Widget\FileUpload\FileUpload"}
{use class="cs\Widget\RadioList\RadioList"}
{use class="cs\Widget\CheckBox\CheckBox"}
{use class="yii\widgets\MaskedInput"}

{registerJs}
    $( "#client_item_tabs" ).tabs();
{/registerJs}


<div class="form_header">
	Карточка клиента
</div>

<div class="client_item_general_inf">

	<div class="client_item_avatar">
		<a href="{FileUpload::getOriginal($user->getAvatar(true), false)}" target="_blank"> 
			<img src="{$user->getAvatar(true)}">
		</a>
	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			Фамилия
		</div>
		
		<div class="client_item_row_value">
			{$user->getLastName()}
		</div>

	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			Имя
		</div>
		
		<div class="client_item_row_value">
			{$user->getNameFirst()}
		</div>

	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			Отчество
		</div>
		
		<div class="client_item_row_value">
			{$user->getMiddleName()}
		</div>

	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			Пол
		</div>
		
		<div class="client_item_row_value">
			{$user->getGenderString()}
		</div>

	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			Местоположение
		</div>
		
		<div class="client_item_row_value">
			{$user->getPlace()}
		</div>

	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			Возраст
		</div>
		
		<div class="client_item_row_value">
			{$user->getAge()}
		</div>

	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			Телефон
		</div>
		
		<div class="client_item_row_value">
			{$user->getPhone()}
		</div>

	</div>

	<div class="client_item_row mini_row">

		<div class="client_item_row_name">
			E-mail
		</div>
		
		<div class="client_item_row_value">
			{Html::mailto($user->getEmail())}
		</div>

	</div>

</div>

<div class="client_item_row_header">
	Паспорт
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Серия
	</div>
	<div class="client_item_row_value">
		{$user->getField('file_passport_ser')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Номер
	</div>
	<div class="client_item_row_value">
		{$user->getField('file_passport_number')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Кем выдан
	</div>
	<div class="client_item_row_value">
		{$user->getField('file_passport_vidan_kem')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Когда выдан
	</div>
	<div class="client_item_row_value">
		{$user->getField('file_passport_vidan_kogda')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Адрес регистрации
	</div>
	<div class="client_item_row_value">
		{$user->getField('file_passport_registration_address')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Дата регистрации
	</div>
	<div class="client_item_row_value">
		{$user->getField('file_passport_registration_date')}
	</div>
</div>

<div class="client_item_doc">
	<a href="{FileUpload::getOriginal($user->getFilePassport(true), false)}" target="_blank"> 
		<img src="{$user->getFilePassport(true)}">
	</a>
</div>

<div class="client_item_row_header">
	Справка 2НДФЛ
</div>

<div class="client_item_doc">
	<a href="{FileUpload::getOriginal($user->getFile2ndfl(true), false)}" target="_blank"> 
		<img src="{$user->getFile2ndfl(true)}">
	</a>
</div>

<div class="client_item_row_header">
	Второй документ, удостоверяющий личность
</div>

<div class="client_item_doc">
	<a href="{FileUpload::getOriginal($user->getFilesSecondIdenty(true), false)}" target="_blank"> 
		<img src="{$user->getFilesSecondIdenty(true)}">
	</a>
</div>

<div class="client_item_row_header">
	Документы, подтверждающие наличие первоначального взноса
</div>

<div class="client_item_doc">
	<a href="{FileUpload::getOriginal($user->getFilesConfirmationPayment(true), false)}" target="_blank"> 
		<img src="{$user->getFilesConfirmationPayment(true)}">
	</a>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Семейное положение
	</div>
	<div class="client_item_row_value">
		{$user->getMaritalStatusString()}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Дети
	</div>
	<div class="client_item_row_value">
		{if $user->getField('s_is_childrens') == 1}
			Есть
		{else}
			Нет
		{/if}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Судимости
	</div>
	<div class="client_item_row_value">
		{if $user->getField('s_is_sud') == 1}
			Есть
		{else}
			Нет
		{/if}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Неисполненные решения судебных органов
	</div>
	<div class="client_item_row_value">
		{if $user->getField('s_is_sud_neisp_resh') == 1}
			Есть
		{else}
			Нет
		{/if}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Судебные иски против Вас
	</div>
	<div class="client_item_row_value">
		{if $user->getField('s_is_sud_sud_isk') == 1}
			Есть
		{else}
			Нет
		{/if}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Работаете?
	</div>
	<div class="client_item_row_value">
		{if $user->getField('s_is_work_now') == 1}
			Да
		{else}
			Нет
		{/if}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		СНИЛС
	</div>
	<div class="client_item_row_value">
		{$user->getSnils()}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Авто
	</div>
	<div class="client_item_row_value">
		{$user->getField('s_auto')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Материнский капитал
	</div>
	<div class="client_item_row_value">
		{if $user->getField('s_is_work_now') == 1}
			Ест
		{else}
			Нет
		{/if}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Сведения об имуществе
	</div>
	<div class="client_item_row_value">
		{$user->getField('i_info_imush')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Созаемщики
	</div>
	<div class="client_item_row_value">
		{$user->getField('i_co_borrowers')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Данные родственников
	</div>
	<div class="client_item_row_value">
		{$user->getField('i_rodnie_list')}
	</div>
</div>

<div class="client_item_row">
	<div class="client_item_row_name">
		Проживание
	</div>
	<div class="client_item_row_value">
		{$user->getHomeTypeString()}
	</div>
</div>
