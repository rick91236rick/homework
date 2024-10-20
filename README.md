### 資料庫測試

#### 題目一
```sql
SELECT SUM(orders.amount) AS may_amount, bnb_id, bnbs.name 
FROM orders 
INNER JOIN bnbs ON orders.bnb_id = bnbs.id
WHERE orders.currency = 'TWD' AND MONTH(orders.created_at) = 5 
GROUP BY orders.amount
ORDER BY may_amount DESC 
LIMIT 10;
```

#### 題目二
* 先使用 explain 查看 index 的使用是否有可以再進行優化的部分
* 可以把 month 的語法去掉改用 between 
* 可以改寫成 sp
* 程式面上可以加上 cache
* 資料庫架構改為讀寫分離(?)

### API 測試

#### 題目一

可以先安裝 make 即可執行寫好的指令，或是可以參考 Makefile 內包好的執行進行執行

```
make service.build
```
環境安裝

```
make service.up
```
架設環境

```
make service.down
```
關閉環境

```
make test
```
執行測試

-------------


設計模式的話，個人認為在存到不同 table 的時候，或許可以採用轉換器模式
但我覺得在這個題目感覺有點多餘，然後其他的 patten 應該就是 listener patten(?)

在程式內應該都有符合單一原則，以及 laravel 的 DI 有符合依賴反轉原則，開閉原則在程式內使用到的 VO 有符合到，至於介面隔離原則與里氏替換原則我沒有實作到

### 架構測試

#### 題目一
並未時做過相關通訊系統的經驗，只有過做過類似聊天室與通知之類的架構，但是有查詢了一下關於相關的通訊系統，感覺我畫出的架構圖應該不是題目所想要的，故此題略過
感覺題目應該是想要關於 net 之間的架構（？，而不是單純軟體上的系統設計架構