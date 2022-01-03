<?php
define("API_KEY","1225097122:AAHcAvJYXQqM2DEOqnR_nVWNQyzAFO9_nVM"); // bot tokeni
$creator = array("1314213542", "1886494959");
$kanal_1 = "@igeyes"; // birinchi kanal usernamesi
$bot = "@pbiuzbot"; // bot useri
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}
mkdir("step");
mkdir("users");
mkdir("baza");
mkdir("baza/music");
mkdir("baza/kino");
mkdir("baza/fayl");
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$name = $message->from->first_name;
$data = $update->callback_query->data;
$callcid = $update->callback_query->message->chat->id;
$callmid = $update->callback_query->message->message_id;
$audio = $update->message->audio;
$audio_name = $update->message->audio->title;
$audio_id = $update->message->audio->file_id; 
$document = $message->document;
$document_name = $document->file_name;
$document_id = $document->file_id;
$video = $message->video;
$video_id = $video->file_id;
$step = file_get_contents("step/$chat_id.txt");
$search = file_get_contents("step/$chat_id.search.txt");
$search2 = file_get_contents("step/$callcid.search.txt");

$getChat1 = bot('getChatmember',[
'chat_id'=>$kanal_1,
'user_id'=>$message->chat->id,
]);
$res1 = $getChat1->result->status;
if($res1 == "left"){
    $kanal_1 = str_replace("@","",$kanal_1);
    $bot = str_replace("@","",$bot);
    bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"*Botdan foydalanish uchun quyidagi kanallarimizga obuna bo'ling

    A'zo bo'lib qayta /start bosing*[.](https://telegra.ph/file/225f28335a0dcb05e69ca.jpg)",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"➕ A'zo bo'lish 🥳",'url'=>"t.me/$kanal_1"]],
    ]
    ]),
    ]);
exit();
}
if($search == false){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Assalomu alaykum, 
Siz $bot orqali nima qidirishni xoxlaysiz.*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎵 Musiqa",'callback_data'=>"music"],['text'=>"🗂 Kitoblar",'callback_data'=>"fayl"],],
]
]),
]);
}
if($text == "/settings"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"*Assalomu alaykum, 
Siz $bot orqali nima qidirishni xoxlaysiz*[.](https://telegra.ph/file/225f28335a0dcb05e69ca.jpg)",
'parse_mode'=>"markdown",
'reply_markup' => json_encode([
'inline_keyboard'=>[
[['text'=>"🎵 Musiqa",'callback_data'=>"music"],['text'=>"🗂 Kitoblar",'callback_data'=>"fayl"],],
]
]),
]);
}
if($data == "music"){
bot('deletemessage',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
]);
file_put_contents("step/$callcid.search.txt",$data);
bot('sendmessage',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
'text'=>"*Shunchaki menga Qo'shiqchi yoki qo'shiq nomini jo'nating va men siz uchun musiqa topib beraman.

/settings - Qidiruv sozlamalari*[.](https://telegra.ph/file/225f28335a0dcb05e69ca.jpg)",
'parse_mode'=>"markdown",
]);
}

if($text == "/start" and $search == true and $search == "music"){
if(!is_dir("users/".$chat_id)){
mkdir("users/".$chat_id);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Shunchaki menga Qo'shiqchi yoki qo'shiq nomini jo'nating va men siz uchun musiqa topib beraman.

/settings - Qidiruv sozlamalari*[.](https://telegra.ph/file/225f28335a0dcb05e69ca.jpg)",
'parse_mode'=>"markdown",
'reply_markup'=>$menu,
]);
}

if($data == "fayl"){
bot('deletemessage',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
]);
file_put_contents("step/$callcid.search.txt",$data);
bot('sendmessage',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
'text'=>"*Menga Kitob nomini yuboring men sizga fayllarni topib beraman.

/settings - Qidiruv sozlamalari*[.](https://telegra.ph/file/225f28335a0dcb05e69ca.jpg)",
'parse_mode'=>"markdown",
]);
}

if($text == "/start" and $search == true and $search == "fayl"){
if(!is_dir("users/".$chat_id)){
mkdir("users/".$chat_id);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Menga Kitob nomini yuboring men sizga fayllarni topib beraman.

/settings - Qidiruv sozlamalari*[.](https://telegra.ph/file/225f28335a0dcb05e69ca.jpg)",
'parse_mode'=>"markdown",
'reply_markup'=>$menu,
]);
}

if($data == "kino"){
file_put_contents("step/$callcid.search.txt",$data);
bot('editmessagetext',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
'text'=>"*Menga yuklab olmoqchi bo'lgan film nomini yuboring men sizga film nitopib beraman.
/settings - Qidiruv sozlamalari*",
'parse_mode'=>"markdown",
]);
}
if($text == "/start" and $search == true and $search == "kino"){
if(!is_dir("users/".$chat_id)){
mkdir("users/".$chat_id);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Menga yuklab olmoqchi bo'lgan film nomini yuboring men sizga film nitopib beraman.
/settings - Qidiruv sozlamalari*",
'parse_mode'=>"markdown",
'reply_markup'=>$menu,
]);
}
//music @ExoBayt
if($text != "/start" and $text != "/add" and $text != "/settings" and $search == "music" and $text != "/panel" and $text != "Bekor qilish" and $text != "Panelni yopish" and $text != "📊 Statistika" and $text != "📝 Xabar yuborish" and $text != "➕ Music" and $text != "#⃣ Forward kabi habar yuborish" and $text != "➕ File" and $text != "Panelni ochish"){
if(isset($text)){
$file = "https://client1458.4bo.ru/searchbot/search.php?text=$text&id=music";
$count_file = count(file($file));
$soni = "$count_file";
file_put_contents("step/$chat_id&search.txt","$text");
$res = file_get_contents("https://client1458.4bo.ru/searchbot/search.php?text=$text&id=music");
$keyboards = array();
for ($for = 1; $for <= $soni; $for++) {
$keyboards[]=["text"=>"$for","callback_data"=>"$for"];
}
$keyboard2=array_chunk($keyboards, 6);
$keyboard=json_encode([
'inline_keyboard'=>$keyboard2,
]);
$max = strlen($text);
if(2<=$max){
if(!empty($res)){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Natijalar: 1-$soni</b>"."\n"."\n".$res,
'parse_mode'=>'html',
'reply_markup'=>$keyboard,
]);
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Hech narsa topilmadi 😔",
'parse_mode'=>'html',
]);
}
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Matn kamida 2 ta belgidam iborat bo'lsin.",
'parse_mode'=>'html',
]);
}
}
}
if($data and $search2 == "music"){
$search=file_get_contents("step/$callcid&search.txt");
$saudio=file_get_contents("https://client1458.4bo.ru/searchbot/get.php?text=$search&nomer=$data&id=music");
bot('sendaudio',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
'audio'=>$saudio,
'reply_markup'=> json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"delete"],],
]
]),
]);
}
// file  @ExoBayt
if($text != "/start" and $text != "/add" and $text != "/settings" and $search == "fayl" and $text != "/panel" and $text != "Bekor qilish" and $text != "Panelni yopish" and $text != "📊 Statistika" and $text != "📝 Xabar yuborish" and $text != "➕ Music" and $text != "#⃣ Forward kabi habar yuborish" and $text != "➕ File" and $text != "Panelni ochish"){
if(isset($text)){
$file = "https://client1458.4bo.ru/searchbot/search.php?text=$text&id=fayl";
$count_file = count(file($file));
$soni = "$count_file";
file_put_contents("step/$chat_id&search.txt","$text");
$res = file_get_contents("https://client1458.4bo.ru/searchbot/search.php?text=$text&id=fayl");
$keyboards = array();
for ($for = 1; $for <= $soni; $for++) {
$keyboards[]=["text"=>"$for","callback_data"=>"$for"];
}
$keyboard2=array_chunk($keyboards, 6);
$keyboard=json_encode([
'inline_keyboard'=>$keyboard2,
]);
$max = strlen($text);
if(2<=$max){
if(!empty($res)){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Natijalar: 1-$soni</b>"."\n"."\n".$res,
'parse_mode'=>'html',
'reply_markup'=>$keyboard,
]);
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Hech narsa topilmadi 😔",
'parse_mode'=>'html',
]);
}
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Matn kamida 2 ta belgidam iborat bo'lsin.",
'parse_mode'=>'html',
]);
}
}
}
if($data and $search2 == "fayl"){
$search=file_get_contents("step/$callcid&search.txt");
$saudio=file_get_contents("https://client1458.4bo.ru/searchbot/get.php?text=$search&nomer=$data&id=fayl");
bot('senddocument',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
'document'=>$saudio,
'reply_markup'=> json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"delete"],],
]
]),
]);
}
// kino @ExoBayt
if($text != "/start" and $text != "/add" and $text != "/settings" and $search == "kino" and $text != "/panel" and $text != "Bekor qilish" and $text != "Panelni yopish" and $text != "📊 Statistika" and $text != "📝 Xabar yuborish" and $text != "➕ Music" and $text != "#⃣ Forward kabi habar yuborish" and $text != "➕ File" and $text != "Panelni ochish"){
if(isset($text)){
$file = "https://client1458.4bo.ru/searchbot/search.php?text=$text&id=kino";
$count_file = count(file($file));
$soni = "$count_file";
file_put_contents("step/$chat_id&search.txt","$text");
$res = file_get_contents("search.php?text=$text&id=kino");
$keyboards = array();
for ($for = 1; $for <= $soni; $for++) {
$keyboards[]=["text"=>"$for","callback_data"=>"$for"];
}
$keyboard2=array_chunk($keyboards, 6);
$keyboard=json_encode([
'inline_keyboard'=>$keyboard2,
]);
$max = strlen($text);
if(2<=$max){
if(!empty($res)){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Natijalar: 1-$soni</b>"."\n"."\n".$res,
'parse_mode'=>'html',
'reply_markup'=>$keyboard,
]);
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Hech narsa topilmadi 😔",
'parse_mode'=>'html',
]);
}
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Matn kamida 2 ta belgidam iborat bo'lsin.",
'parse_mode'=>'html',
]);
}
}
}
if($data and $search2 == "kino"){
$search=file_get_contents("step/$callcid&search.txt");
$saudio=file_get_contents("https://client1458.4bo.ru/searchbot/get.php?text=$search&nomer=$data&id=kino");
bot('sendvideo',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
'video'=>$saudio,
'caption'=>$data.' '."raqamli kino",
'reply_markup'=> json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"delete"],],
]
]),
]);
}
// delete  @ExoBayt
if($data == "delete"){
bot('deleteMessage',[
'chat_id'=>$callcid,
'message_id'=>$callmid,
]);
}
// panel @exobayt
if(in_array($chat_id,$creator)){
if($text == "/panel"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"Admin(ka) panelga xush kelibsiz !",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"📝 Xabar yuborish"],["text"=>"📊 Statistika"],],
[["text"=>"➕ Music"],["text"=>"➕ File"],],
[["text"=>"Panelni yopish"],],
]
]),
]);
}
if($text == "📝 Xabar yuborish"){ 
file_put_contents("step/$chat_id.txt","send");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"Xabaringizni kiriting:",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"#⃣ Forward kabi habar yuborish"],],
[["text"=>"Bekor qilish"],],
]
]),
]);
}
if($text == "#⃣ Forward kabi habar yuborish"){ 
bot('deletemessage',[
'chat_id'=>$chat_id,
'message_id'=>$message->message_id-1,
]);
bot('deletemessage',[
'chat_id'=>$chat_id,
'message_id'=>$message->message_id,
]);
file_put_contents("step/$chat_id.txt","for");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"Forward xabaringizni kiriting:",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"Bekor qilish"],],
]
]),
]);
}
if($step == "send" and $text != "Bekor qilish" and $text != "#⃣ Forward kabi habar yuborish"){
file_put_contents("step/$chat_id.txt","");
foreach(scandir("users/") as $dir){
if(!empty($dir == "." or $dir == "..")){continue;}
$dirs .= "$dir\n";
}
file_put_contents("statistika.txt",$dirs);
$azo=file_get_contents("statistika.txt");
$count = substr_count($azo,"\n");
$ex=explode("\n",$dirs); 
foreach($ex as $user_id){
$res =  bot('copyMessage',[ 
'chat_id'=>$user_id, 
'from_chat_id'=>$chat_id, 
'message_id'=> $message->message_id
]);
unlink("statistika.txt");
$res = $res->ok;
if($res == 'true'){
$i++;
}
}
$a=$count-$i;
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Result:*
------------
✅ *Sent:* [$i]
❎ *Not sent:* [$a]",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"📝 Xabar yuborish"],["text"=>"📊 Statistika"],],
[["text"=>"➕ Music"],["text"=>"➕ File"],],
[["text"=>"Panelni yopish"],],
]
]),
]);
}
if($step == "for" and $text != "Bekor qilish" and $text != "📝 Xabar yuborish"){
file_put_contents("step/$chat_id.txt","");
foreach(scandir("users/") as $dir){
if(!empty($dir == "." or $dir == "..")){continue;}
$dirs .= "$dir\n";
}
file_put_contents("statistika.txt",$dirs);
$azo=file_get_contents("statistika.txt");
$count = substr_count($azo,"\n");
$ex=explode("\n",$dirs); 
foreach($ex as $user_id){
$res =  bot('forwardMessage',[ 
'chat_id'=>$user_id, 
'from_chat_id'=>$chat_id, 
'message_id'=> $message->message_id
]);
unlink("statistika.txt");
$res = $res->ok;
if($res == 'true'){
$i++;
}
}
$a=$count-$i;
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Result:*
------------
✅ *Sent:* [$i]
❎ *Not sent:* [$a]",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"📝 Xabar yuborish"],["text"=>"📊 Statistika"],],
[["text"=>"➕ Music"],["text"=>"➕ File"],],
[["text"=>"Panelni yopish"],],
]
]),
]);
}
if($text == "Bekor qilish"){
unlink("step/$chat_id.txt");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Bosh menu*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"📝 Xabar yuborish"],["text"=>"📊 Statistika"],],
[["text"=>"➕ Music"],["text"=>"➕ File"],],
[["text"=>"Panelni yopish"],],
]
]),
]);
}
if($text == "Panelni yopish"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Bosh menu*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"Panelni ochish"],],
]
]),
]);
}
if($text == "Panelni ochish"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*Panel yopildi:*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"📝 Xabar yuborish"],["text"=>"📊 Statistika"],],
[["text"=>"➕ Music"],["text"=>"➕ File"],],
[["text"=>"Panelni yopish"],],
]
]),
]);
}
if($text == "📊 Statistika"){ 
foreach(scandir("users/") as $dir){
if(!empty($dir == "." or $dir == "..")){continue;}
$dirs .= "$dir\n";}
$ex=explode("\n",$dirs); 
foreach($ex as $user_id){
file_put_contents("statistika.txt",$dirs);
$azo=file_get_contents("statistika.txt");
}
$statistika = substr_count($azo,"\n");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"Foydalanuvchilar: $statistika ta",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"Bekor qilish"],],
]
]),
]);
unlink("statistika.txt");
}
if($text == "➕ Music" and $text != "Bekor qilish"){
file_put_contents("step/$chat_id.txt","addmusic");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Yuklamoqchi bo'lgan qo'shig'ingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"Bekor qilish"],],
]
]),
]);
}
if($audio){
if($step == "addmusic"){
if(!is_file("baza/music/$audio_name")){
file_put_contents("baza/music/$audio_name","$audio_id");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>✅ Musiqa bazaga yuklandi:\n\n$audio_name</b>",
'parse_mode'=>"html",
]);
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>❌ Ushbu qo'shiq bazada mavjud:\n\n$audio_name</b>",
'parse_mode'=>"html",
]);
}
}
}
if($text == "➕ File"){
file_put_contents("step/$chat_id.txt","addfayl");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Yuklamoqchi bo'lgan faylingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"Bekor qilish"],],
]
]),
]);
}
if($document){
if($step == "addfayl"){
if(!is_file("baza/fayl/$document_name")){
file_put_contents("baza/fayl/$document_name","$document_id");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>✅ Fayl bazaga yuklandi:\n\n$document_name</b>",
'parse_mode'=>"html",
]);
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>❌ Ushbu fayl bazada mavjud:\n\n$audio_name</b>",
'parse_mode'=>"html",
]);
}
}
}
if($text == "➕ Kino" and $text != "Bekor qilish"){
file_put_contents("step/$chat_id.txt","kinos");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Kino nomini kiriting:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"Bekor qilish"],],
]
]),
]);
}
if($step == "kinos" and $text != "Bekor qilish"){
file_put_contents("step/$chat_id.txt","addkino");
file_put_contents("step/kino.$chat_id.txt",$text);
if(!is_file("baza/kino/$text")){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Kinoni yuboring:</b>",
'parse_mode'=>"html",
]);
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>❌ Ushbu kino bazada mavjud:\n\n$text</b>",
'parse_mode'=>"html",
]);
}
}
if($video){
$vget=file_get_contents("step/kino.$chat_id.txt");
if($step == "addkino"){
if(!is_file("baza/kino/$text")){
file_put_contents("baza/kino/$vget","$video_id");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>✅ Fayl bazaga yuklandi:\n\n$vget</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"📝 Xabar yuborish"],["text"=>"📊 Statistika"],],
[["text"=>"➕ Music"],["text"=>"➕ File"],],
[["text"=>"Panelni yopish"],],
]
]),
]);
unlink("step/$chat_id.txt","");
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>❌ Ushbu fayl bazada mavjud:\n\n$vget</b>",
'parse_mode'=>"html",
]);
}
}
}
}

?>