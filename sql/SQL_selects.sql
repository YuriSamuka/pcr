/*Seleciona dois requisitos da mesma tabela que estão relacionados na tabela rastreabilidade*/
--Sql brado de fazer!...

select
	rf_l.id_rf as cod_rf_l,
    rf_r.id_rf as cod_rf_r
from 
	rastreabilidade ras
    inner join  rf as rf_l on rf_l.id_rf = ras.id_rf_left
    inner join rf as rf_r on rf_r.id_rf = ras.id_rf_right