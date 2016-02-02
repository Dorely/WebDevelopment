-- Convert and insert raw data

 insert into sets
 (select 
  NULL
 ,nname
 ,ncode
 ,ncode_magiccards
 ,STR_TO_DATE(ndate, '%m/%Y')
 from nsets 
 order by 5);
 
 insert into cards
(select
 NULL
,(select set_id from sets where sets.official_code = ncards.Nset)
,Nname
,Ntype
,Nrarity
,Nmanacost
,Nconverted_manacost
,Npower
,Ntoughness
,Nloyalty
,Nability
,Nflavor
,Nvariation
,Nartist
,Nnumber
,Nruling
,Ncolor
from ncards);