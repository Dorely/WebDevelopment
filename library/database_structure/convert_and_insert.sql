-- Convert and insert raw data

 insert into sets
 (select 
  NULL
 ,Nname
 ,Ncode
 ,Ncode_magiccards
 ,STR_TO_DATE(Ndate, '%m/%Y')
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
,null
,null
,null
from ncards);