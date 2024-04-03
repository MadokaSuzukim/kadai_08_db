INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test1', 'test1@test.jp', '10', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test2', 'test2@test.jp', '20', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test3', 'test3@test.jp', '10', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test4', 'test4@test.jp', '20', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test5', 'test5@test.jp', '20', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test6', 'test6@test.jp', '30', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test7', 'test7@test.jp', '40', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test8', 'test8@test.jp', '50', 'test', sysdate());

INSERT INTO gs_an_table (id, name, email, age, naiyou, indate) VALUES (NULL, 'test9', 'test9@test.jp', '10', 'test', sysdate());


SELECT * FROM gs_an_table; //全部とってくる
SELECT id,name,indate FROM gs_an_table;　　　　//カラムを指定してとってくることができる。

SELECT *FROM gs_an_table WHERE id=1;

SELECT *FROM gs_an_table WHERE id>=1 AND id<=3;

SELECT *FROM gs_an_table ORDER BY indate DESC;　//大きい順から並び替える
SELECT *FROM gs_an_table ORDER BY indate ASC;   //数字１から順に並べ替える

SELECT *FROM gs_an_table ORDER BY indate DESC LIMIT 3;　//大きい順から3つ

id>=1 AND id<=3;
