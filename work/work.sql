-- INSERT文の基本構造
--INSERT INTO テーブル名 (カラム1, カラム2, ...) VALUES (値1, 値2, ...);
-- 「カラム名の数と順序」と「値の数と順序」を一致させる必要がある．
-- id カラムは DB 側で Auto increment の設定をしているため NULL を送信する．
-- 作成日時や更新日時は now() を使用して実行時の日付時刻が入力されるようにする．
INSERT INTO sleep_table (id, sleep_start_time, sleep_end_time, feel, comment, created_at, updated_at) VALUES(NULL, '2024-05-31 00:00:00', '2024-05-31 00:00:00', 5, 'これはテキストの例です。', now(), now());

INSERT INTO sleep_table (id, sleep_start_time, sleep_end_time, feel, comment, created_at, updated_at) VALUES(NULL, '2024-06-01 00:00:00', '2024-06-01 00:00:00', 4, 'これはテキストの例です。', now(), now());

INSERT INTO sleep_table (id, sleep_start_time, sleep_end_time, feel, comment, created_at, updated_at) VALUES(NULL, '2024-06-02 00:00:00', '2024-06-02 00:00:00', 1, 'これはテキストの例です3。', now(), now());

INSERT INTO sleep_table (id, sleep_start_time, sleep_end_time, feel, comment, created_at, updated_at) VALUES(NULL, '2024-06-03 00:00:00', '2024-06-03 00:00:00', 1, 'これはテキストの例です4。', now(), now());

-- INSERT INTO sleep_table (id, sleep_start_time, sleep_end_time, feel, comment, created_at, updated_at) VALUES(NULL, :sleep_start_time, :sleep_end_time, :feel, :comment, now(), now());

-- SELECT文の基本構造
--SELECT 表示するカラム名 FROM テーブル名;
SELECT * FROM sleep_table;
-- 例
-- 「*」で全て指定
SELECT * FROM todo_table;
-- 1つのカラムを指定
SELECT todo FROM todo_table;
-- 複数カラム指定
SELECT todo, deadline FROM todo_table;