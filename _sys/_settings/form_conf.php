<?php

$option_setting = array(
 /******************************************************************************
 フォームの選択肢タイプのものはすべてこのリストで管理
・キーは必ずフォームのnameと同じにする 
・このリストを表示させるSmartyのテンプレート変数名はname * '_loop'とする。
　（define.phpで変更可能）

・改行で区切る。1選択肢1行。
・プルダウンでoptgroupを使う場合は、グループを要素の1つ目、
　選択肢を要素の2つ目に入れる。2つ目の前には,が必要（都道府県リストを参考）
　ただし、2階層目まで。
・各行の前後の空白文字は無視される。
・空行は無視されない。

＊ほかに、別ファイルにデータを持たせる方法も有り。
 *******************************************************************************/
	 
	'pref' => "↓
	北海道
	青森県
	岩手県
	宮城県
	秋田県
	山形県
	福島県
	栃木県
	茨城県
	群馬県
	埼玉県
	千葉県
	東京都
	神奈川県
	新潟県
	富山県
	石川県
	福井県
	山梨県
	長野県
	岐阜県
	静岡県
	愛知県
	三重県
	滋賀県
	京都府
	大阪府
	兵庫県
	奈良県
	和歌山県
	鳥取県
	島根県
	岡山県
	広島県
	山口県
	徳島県
	香川県
	愛媛県
	高知県
	福岡県
	佐賀県
	長崎県
	熊本県
	大分県
	宮崎県
	鹿児島県
	沖縄県",

	'spref' => "↓
	北海道
	青森県
	岩手県
	宮城県
	秋田県
	山形県
	福島県
	栃木県
	茨城県
	群馬県
	埼玉県
	千葉県
	東京都
	神奈川県
	新潟県
	富山県
	石川県
	福井県
	山梨県
	長野県
	岐阜県
	静岡県
	愛知県
	三重県
	滋賀県
	京都府
	大阪府
	兵庫県
	奈良県
	和歌山県
	鳥取県
	島根県
	岡山県
	広島県
	山口県
	徳島県
	香川県
	愛媛県
	高知県
	福岡県
	佐賀県
	長崎県
	熊本県
	大分県
	宮崎県
	鹿児島県
	沖縄県",
	
	'user_send' => "上記（お申し込み者）と同じです。",
	
	'rb_time' => "希望なし
	午前中
	12～14時
	14～16時
	16～18時
	18～20時
	20～21時",
			
	'payment' => "クレジットカード
	代金引換（代引手数料1回210円）",
	
	
	);

$validation_list = array(	
/***********************************************************************************************************************************************
****配列のキーは必ずフォームのnameに対応***
2階層目の各配列のキーは以下
	required: 			1必須、2:条件必須  3:他の項目といづれか必須
	required_width:		requiredが3の場合の他の項目
	maxlength: 			最大文字数
	length: 			文字数
	equal_to:			指定の値と等しいかどうか。直接指定するか、$_POSTなどのグローバル変数も指定可能。
	limit_char: 		文字種 num, hira, kana。num, hirra, kanaはsprayValidatorクラスのメソッドになっている。同様にメソッドを追加して拡張可能
	multi_count:		回答数が指定数と同じ
	multi_min_count:	回答数が指定個数以上
	multi_max_count:	回答数が指定個数以下
	data_file:			選択項目をデータファイルで持たせる場合のファイル名
	delimiter:			データファイルのデリミタ
	limit_expression:	任意のパターンにマッチするかをチェック。正規表現で指定する。
	limit_array: 		値を配列で指定されたものに限定する。有効にする場合はここにフォームのname * '_list'という文字列をセットする。
	error（配列）: 		上記の各チェックに対応したエラーメッセージを指定。キーは上記のキーを使用
	error_tag: 			エラーメッセージを挿入するsmartyのテンプレートタグ変数
	multi:				複数回答あり・なし（1, 0)
	cond_name:			条件付き必須の条件となる選択肢のname
	cond_value:			条件付き必須の条件の値
	count:				項目の選択個数（プルダウンで生成）最低値,最高値
	data_file:			選択肢を$option_settingに持たせずに別ファイルで指定する場合
	var_name:			nemeを項目ごとに通番で指定したい場合
	var_count:			var_nameで指定する場合の最大値（0～）
************************************************************************************************************************************************/	

	'course' => array('required' => 3,
					  'required_with' => array('fruits'),
					  'count' => "1,10",
					   'error' => array('required' => '商品が選ばれてません', 'count' => '商品は1～10個までの範囲でお選びください。'),
					   'error_tag' => 'course_err'
					  
	),
	
	'fruits' => array('required' => 0,
					  'data_file' => 'includes/data/fhanpu_dat.txt',
					  'delimiter' => "\t",
					  'var_name' => 'fruits_',
					  'var_count' => 11,
					  'multi' => 1,
					  'count' => "1,10",
					  'error' => array('required' => '商品が選ばれてません', 'count' => '商品は1～10個までの範囲でお選びください。'),
					   'error_tag' => 'course_err'
	
	),
	
	'user_name' => array('required' => 1,
					   'maxlength' => 128,
					   'error' => array('required' => 'お名前が入力されていません', 'maxlength' => 'お名前は128文字以内でご入力ください'),
					   'error_tag' => 'user_name_err'
	),

	'user_namef' => array('required' => 1,
					   'maxlength' => 128,
					   'limit_char' => 'hira',
					   'error' => array('required' => 'ふりがなが入力されていません', 'maxlength' => 'ふりがなは128文字以内でご入力ください', 'limit_char' => 'ふりがなは全角ひらがなでご入力ください'),
					   'error_tag' => 'user_namef_err'
	),

	'zip' => array('required' => 1,
					   'length' => 7,
					   'limit_char' => 'num',
					   'error' => array('required' => '郵便番号が入力されていません', 'length' => '郵便番号は7文字でご入力ください', 'limit_char' => '郵便番号は半角数字でご入力ください'),
					   'error_tag' => 'zip_err'
	),
	
	'pref' => array('required' => 1,
					   'maxlength' => 2,
					   'limit_char' => 'num',
					   'empty_first' => 1,
					   'limit_array' => 'pref_list',
					   'error' => array('required' => '都道府県が選択されていません', 'maxlength' => '都道府県が選択されていません', 'limit_char' => '都道府県が選択されていません', 'limit_array' => '都道府県が選択されていません'),
					   'error_tag' => 'pref_err'
	),

	'addr' => array('required' => 1,
					   'maxlength' => 500,
					   'error' => array('required' => 'ご住所が入力されていません', 'maxlength' => 'ご住所は500文字以内でご入力ください'),
					   'error_tag' => 'addr_err'
	),

	'addr2' => array('required' => 0,
					   'maxlength' => 500,
					   'error' => array('required' => 'ご住所が入力されていません', 'maxlength' => 'ご住所は500文字以内でご入力ください'),
					   'error_tag' => 'addr2_err'
	),
					   					   
	'user_tel1' => array('required' => 1,
					   'maxlength' => 11,
					   'minlength' => 10,
					   'limit_char' => 'num',
					   'error' => array('required' => '電話番号が入力されていません', 'maxlength' => '電話番号は10ケタか、11ケタでご入力ください', 'minlength' => '電話番号は10ケタか、11ケタでご入力ください','limit_char' => '電話番号は半角数字でご入力ください'),
					   'error_tag' => 'user_tel1_err'
	),
					   					   
	'user_fax' => array('required' => 0,
					   'maxlength' => 11,
					   'minlength' => 10,
					   'limit_char' => 'num',
					   'error' => array('required' => 'FAX番号が入力されていません', 'maxlength' => 'FAX番号は10ケタか、11ケタでご入力ください', 'minlength' => 'FAX番号は10ケタか、11ケタでご入力ください', 'limit_char' => 'FAX番号は半角数字でご入力ください'),
					   'error_tag' => 'user_fax_err'
	),
					   
	'user_email1' => array('required' => 1,
					   'maxlength' => 128,
					   'limit_expression' => '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',
					   'equal_to' => $_POST['user_email2'],
					   'error' => array('required' => 'メールアドレスが入力されていません', 'maxlength' => 'メールアドレスは128文字以内でご入力ください', 'limit_expression' => 'メールアドレスは半角英数字でご入力ください', 'equal_to' => 'メールアドレスが一致しません'),
					   'error_tag' => 'user_email1_err'
	),
					   
//////////////////////ここからお届け先///////////////////////////

	'send_name' => array('required' => 2,
					   'cond_name' => 'user_send',
					   'cond_value' => "",
					   'maxlength' => 128,
					   'error' => array('required' => '届け先のお名前が入力されていません', 'maxlength' => '届け先のお名前は128文字以内でご入力ください'),
					   'error_tag' => 'send_name_err'
	),

	'send_namef' => array('required' => 2,
					   'cond_name' => 'user_send',
					   'cond_value' => "",
					   'maxlength' => 128,
					   'limit_char' => 'hira',
					   'error' => array('required' => 'ふりがなが入力されていません', 'maxlength' => 'ふりがなは200文字以内でご入力ください', 'limit_char' => 'ふりがなは全角ひらがなでご入力ください'),
					   'error_tag' => 'send_namef_err'
	),
					   
	'szip' => array('required' => 2,
					   'cond_name' => 'user_send',
					   'cond_value' => "",
					   'empty_first' => 1,
					   'length' => 7,
					   'limit_char' => 'num',
					   'error' => array('required' => 'お届け先の郵便番号が入力されていません', 'length' => 'お届け先の郵便番号は7文字でご入力ください', 'limit_char' => 'お届け先の郵便番号は半角数字でご入力ください'),
					   'error_tag' => 'szip_err'
	),
	
	'spref' => array('required' => 2,
					   'cond_name' => 'user_send',
					   'cond_value' => "",
					   'maxlength' => 2,
					   'limit_char' => 'num',
					   'limit_array' => 'spref_list',
					   'error' => array('required' => 'お届け先の都道府県が選択されていません', 'maxlength' => 'お届け先の都道府県が選択されていません', 'limit_char' => 'お届け先の都道府県が選択されていません', 'limit_array' => 'お届け先の都道府県が選択されていません'),
					   'error_tag' => 'spref_err'
	),

	'saddr' => array('required' => 2,
					   'cond_name' => 'user_send',
					   'cond_value' => "",
					   'maxlength' => 500,
					   'error' => array('required' => 'お届け先のご住所が入力されていません', 'maxlength' => 'お届け先のご住所は500文字以内でご入力ください'),
					   'error_tag' => 'saddr_err'
	),

	'saddr2' => array('required' => 0,
					   'maxlength' => 500,
					   'error' => array('required' => 'ご住所が入力されていません', 'maxlength' => 'ご住所は500文字以内でご入力ください'),
					   'error_tag' => 'saddr2_err'
	),
					   					   
	'suser_tel1' => array('required' => 2,
					   'cond_name' => 'user_send',
					   'cond_value' => "",
					   'maxlength' => 11,
					   'minlength' => 10,
					   'limit_char' => 'num',
					   'error' => array('required' => '電話番号が入力されていません', 'maxlength' => '電話番号は10ケタか、11ケタでご入力ください', 'minlength' => '電話番号は10ケタか、11ケタでご入力ください','limit_char' => '電話番号は半角数字でご入力ください'),
					   'error_tag' => 'suser_tel1_err'
	),


///////////////////////////////////////////////////////////////
		'rb_time' => array('required' => 1,
					   'maxlength' => 1,
					   'limit_char' => 'num',
					   'limit_array' => 'rb_time_list',
					   'error' => array('required' => 'ご希望のお届け時間帯が選択されていません', 'maxlength' => 'ご希望のお届け時間帯が選択されていません', 'limit_char' => 'ご希望のお届け時間帯が選択されていません'),
					   'error_tag' => 'rb_time_err'
	),  	
					   
		'payment' => array('required' => 1,
					   'maxlength' => 1,
					   'limit_char' => 'num',
					   'limit_array' => 'payment_list',
					   'error' => array('required' => 'ご決済方法が選択されていません', 'maxlength' => 'ご決済方法が選択されていません', 'limit_char' => 'ご決済方法が選択されていません'),
					   'error_tag' => 'payment_err'
					   ),
					   
		'user_other' => array(
					   'maxlength' => 1000,
					   'error' => array('maxlength' => '通信欄は1000文字以内でご入力ください'),
					   'error_tag' => 'user_other_err'
		)
				
);

?>