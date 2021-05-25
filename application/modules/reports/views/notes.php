
https://docs.google.com/document/d/1RZPZewepdO3xk_3GszSaqmtWQbNP82LhkA7intTikCs/edit#heading=h.ptmlnfkek1xn


http://45.33.105.92/ETA/reports/purchase_report/132 (132 is consumern id in user table )
http://45.33.105.92/ETA/reports/ia_sales_report/45 (45 is ia id in user table )

http://localhost/ETA/reports/purchase_report/132
http://localhost/ETA/reports/ia_sales_report/45

http://localhost/ETA/reports/lic_disbursment_report/98
http://localhost/ETA/reports/ia_disbursment_report/134
http://localhost/ETA/reports/ia_transaction_summary/134

http://localhost/ETA/reports/lic_reconciliation_report/110 (110,98 lic id)
http://localhost/ETA/reports/ia_reconciliation_report/45(45,134 ia id)



CRON
http://localhost/ETA/reports/sales_report/132



reconciliation
1.take all ia of lic
2.take all consumer of these ia
3.fetch order done by these consumers

a consumer ne abc product kitni baar purchas kiya he
a consumer ne xyz product kitni baar purchas kiya he

b consumer ne abc product kitni baar purchas kiya he
b consumer ne xyz product kitni baar purchas kiya he

c consumer ne abc product kitni baar purchas kiya he
c consumer ne xyz product kitni baar purchas kiya he


transaction summary
1.create 3 columns in order table
eta_disburs
lic_disburs
ia_disburs

question do i need to store all 4 prices in
