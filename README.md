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

##### 聊天室架構

![聊天室架構](%E8%81%8A%E5%A4%A9%E5%AE%A4.png)

雙方 client 透過 web socket 進行溝通，但會定期或是在事件結束時推 queue 
server 會訂閱相關 topic 並將相關資料存入資料庫

##### 視訊與通話架構

![視訊與通話架構](%E8%A6%96%E8%A8%8A%E8%88%87%E9%80%9A%E8%A9%B1.png)

首先 client 會透過 http 向 server 發出建立需求，其後由雙方 client 透過 webRTC 進行溝通