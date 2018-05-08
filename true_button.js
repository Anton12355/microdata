(function () {
	tinymce.PluginManager.add( 'true_mce_button', function ( editor ) { // ID кнопки true_mce_button должен быть везде один и тот же
		editor.addButton( 'true_mce_button', { // ID кнопки true_mce_button
			icon : 'home', // мой собственный CSS класс, благодаря которому я задам иконку кнопки
			type : 'menubutton',
			title : 'Вставить контактные данные', // всплывающая подсказка при наведении
			menu : [ // тут начинается первый выпадающий список
				{
					text : 'Редактировать',
					onclick : function () {
						editor.windowManager.open( {
							title : 'Введите контактные данные компании',
							body : [
								{
									type : 'textbox', // тип textbox = текстовое поле
									name : 'company_name', // ID, будет использоваться ниже
									label : 'Название компании', // лейбл
									value : '"Лучшие телефоны"' // значение по умолчанию
								},
								{
									type : 'textbox', // тип textbox = текстовое поле
									name : 'street', // ID, будет использоваться ниже
									label : 'Улица и дом', // лейбл
									value : 'ул. Торговая, д. 1' // значение по умолчанию
								},
								{
									type : 'textbox', // тип textbox = текстовое поле
									name : 'postal_code', // ID, будет использоваться ниже
									label : 'Почтовый индекс', // лейбл
									value : 123456 // значение по умолчанию
								},
								{
									type : 'textbox', // тип textbox = текстовое поле
									name : 'locality', // ID, будет использоваться ниже
									label : 'Населённый пункт', // лейбл
									value : 'Москва' // значение по умолчанию
								},
								{
									type : 'textbox', // тип textbox = текстовое поле
									name : 'phone', // ID, будет использоваться ниже
									label : 'Телефон', // лейбл
									value : '+7 495 123–45–67' // значение по умолчанию
								},
								{
									type : 'textbox', // тип textbox = текстовое поле
									name : 'fax', // ID, будет использоваться ниже
									label : 'Факс', // лейбл
									value : '+7 495 123–45–67' // значение по умолчанию
								},
								{
									type : 'textbox', // тип textbox = текстовое поле
									name : 'email', // ID, будет использоваться ниже
									label : 'Электронная почта', // лейбл
									value : 'admin@phones-best.ru' // значение по умолчанию
								}
							],
							onsubmit : function ( e ) { // это будет происходить после заполнения полей и нажатии кнопки отправки
								editor.insertContent( '[contacts company_name="' + e.data.company_name + '" street="' + e.data.street +
									'" postal_code="' + e.data.postal_code + '" locality="' + e.data.locality +
									'" phone="' + e.data.phone + '" fax="' + e.data.fax + '" email="' + e.data.email  + '"]' );
							}
						} );
					}

				},
				{ // второй элемент первого выпадающего списка, просто вставляет [contacts]
					text : 'Шорткод [contacts]',
					onclick : function () {
						editor.insertContent( '[contacts]' );
					}
				}
			]
		} );
	} );
})();