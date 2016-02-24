Dobrý den,<br />
<br />
pro Váš učet v ChemLab systému byla vyžádána změna přístupového hesla.<br />
Pro dokončení změna hesla pokračujte na tomto odkaze: {{ url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}<br />
<br />
Pokud změna hesla nebyla vyžádána Vaší osobou, tento email prosím ignorujte.<br />
<br />
S pozdravem,<br />
Admin Chem Lab
