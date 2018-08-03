test
====

A Symfony project created on November 2, 2016, 5:09 pm.

1) на странице репозитория имеется кнопочка «Fork», которую и следует нажать.

2) После чего, эту свою копию уже можно «стянуть» на свой компьютер:
git clone https://github.com/andreyQw/Countries.git

3)Склонированный репозиторий имеет одну привязку к удалённому репозиторию, названную origin, которая указывает на вашу копию на GitHub, а не на оригинальный репозиторий, чтобы отслеживать изменения и в нём, вам нужно будет добавить другую привязку, названную, например, second_user.

cd Countries
git remote add second_user https://github.com/andreyQw/Countries.git
git fetch second_user

