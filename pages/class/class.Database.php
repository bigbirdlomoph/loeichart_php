<?php
Class Database{
		private $charset='utf8';
		private $rs;
		private $conn;
		public function __construct($host,$user,$pass,$db_name)
		{
				$this->conn=mysql_connect($host,$user,$pass) or die(mysql_error());				
				mysql_query("SET NAMES utf8");
				mysql_select_db($db_name);	
						   
		}
		public function Query($StrSql)
		 {
				$this->rs=mysql_query($StrSql);
			
		}
		public function Numrow()
		{
				 return mysql_num_rows($this->rs);	
		}
		public function Fetch_row()
		{
				 return mysql_fetch_row($this->rs);	
		}
		public function Fetch_assoc()
		{
		       return mysql_fetch_assoc($this->rs);	
		}
		
		public function Fetch_array()
		{
		 	 return mysql_fetch_array($this->rs);	
		}
		public function Fetch_field()
		{
		 	 return mysql_fetch_field($this->rs);	
		}
		public function Fetch_object()
		{
		 	 return mysql_fetch_object($this->rs);	
		}
		public function Insert($Table,$Field,$Value)
		{
			 mysql_query("insert into $Table ($Field) values ($Value)");
				
		}
		public function Update($Table,$Command,$Condition)
		{
			 mysql_query("UPDATE $Table SET $Command $Condition");
		}
		public function Close_Conn()
		{
			return mysql_close($this->conn);
		}
//กลุ่มวัยระดับอำเภอ
		public function GET_AGE_GROUP_AMP($table,$age)
		{
			$this->rs=mysql_query("SELECT * FROM $table");
		}
	    
//กลุ่มวัยระดับตำบล
		public function GET_AGE_GROUP_TAMBON($table,$age,$ampcode){
			$this->rs=mysql_query("SELECT 
										tb1.TBCODE,
										tb1.TBNAME,
										CASE WHEN tb2.CC='' THEN '0' 
											 WHEN tb2.CC<>'' THEN tb2.CC
										ELSE '0' END AS SUMMARY,
										CASE WHEN tb3.M='' THEN '0' 
											 WHEN tb3.M<>'' THEN tb3.M
										ELSE '0' END AS MALE,
										CASE WHEN tb4.FM='' THEN '0' 
											 WHEN tb4.FM<>'' THEN tb4.FM
										ELSE '0' END AS FEMALE
								
								FROM(
									   SELECT 
										 tambonname as TBNAME,
												tamboncodefull as TBCODE,
												ampurcode as AMPCODE
									   FROM z42_tambon
									   GROUP BY tamboncodefull 
								) as tb1
								LEFT JOIN
								(
										SELECT 
									  CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,
										COUNT(*) as CC
										FROM $table 
										WHERE AGE >='".$age."'		
									GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON) 
								) as tb2 ON tb1.TBCODE=tb2.TBCODE
								LEFT JOIN 
								(
								   SELECT 
										 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
										COUNT(*) as M
										FROM  $table 
									WHERE SEX='1' AND  AGE >='".$age."' 
										GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
								)as tb3 ON tb1.TBCODE=tb3.TBCODE 
								LEFT JOIN 
								(
								SELECT 
										 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
										 COUNT(*) as FM
										FROM  $table 
									WHERE SEX='2' AND  AGE >='".$age."'  
									GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
								)as tb4 ON tb1.TBCODE=tb4.TBCODE 
								
								WHERE tb1.AMPCODE='".$ampcode."'
								GROUP BY tb1.TBCODE
								
								UNION ALL
								
								SELECT 
										'' ,
										'รวม', 
										SUM(tb2.CC) as SUMMARY,
										 SUM(tb3.M) as MALE,
										 SUM(tb4.FM) as FEMALE
										
								
								FROM(
									   SELECT 
										 tambonname as TBNAME,
												tamboncodefull as TBCODE,
												ampurcode as AMPCODE
									   FROM z42_tambon
									   GROUP BY tamboncodefull 
								) as tb1
								LEFT JOIN
								(
										SELECT 
									  CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,
										COUNT(*) as CC
										FROM $table 
										WHERE AGE >='".$age."'		
									GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON) 
								) as tb2 ON tb1.TBCODE=tb2.TBCODE
								LEFT JOIN 
								(
								   SELECT 
										 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
										COUNT(*) as M
										FROM  $table 
									WHERE SEX='1' AND  AGE >='".$age."' 
										GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
								)as tb3 ON tb1.TBCODE=tb3.TBCODE 
								LEFT JOIN 
								(
								SELECT 
										 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
										 COUNT(*) as FM
										FROM  $table 
									WHERE SEX='2' AND  AGE >='".$age."'  
									GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
								)as tb4 ON tb1.TBCODE=tb4.TBCODE 
								
								WHERE tb1.AMPCODE='".$ampcode."'
								#GROUP BY tb1.TBCODE;
								");
		
		
		}
//กลุ่มวัยระดับpcu
		public function GET_AGE_GROUP_PCU($table,$age,$tambon){
			$this->rs=mysql_query("SELECT 
										tb1.HOSPCODE,
										tb1.HOSPNAME,
								
										CASE WHEN tb2.CC='' THEN '0' 
											 WHEN tb2.CC<>'' THEN tb2.CC
										ELSE '0' END AS SUMMARY,
										CASE WHEN tb3.M='' THEN '0' 
											 WHEN tb3.M<>'' THEN tb3.M
										ELSE '0' END AS MALE,
										CASE WHEN tb4.FM='' THEN '0' 
											 WHEN tb4.FM<>'' THEN tb4.FM
										ELSE '0' END AS FEMALE
								
								FROM(
									   SELECT 
										   co_village_loei.hospcode as HOSPCODE,
													 42co_office_loei.off_name as HOSPNAME,
													 co_village_loei.subdistid as subdistid 
									   FROM co_village_loei
									 LEFT OUTER JOIN 42co_office_loei  ON co_village_loei.hospcode=42co_office_loei.off_id
									   GROUP BY hospcode 
								) as tb1
								LEFT JOIN
								(
										SELECT 
									  HOSPCODE as HOSPCODE,
										COUNT(*) as CC
										FROM $table 
										WHERE AGE >='".$age."'		
									GROUP BY HOSPCODE 
								) as tb2 ON tb1.HOSPCODE=tb2.HOSPCODE
								LEFT JOIN 
								(
								   SELECT 
										 HOSPCODE as HOSPCODE,		
										COUNT(*) as M
										FROM  $table 
									WHERE SEX='1' AND  AGE >= '".$age."' 
										GROUP BY HOSPCODE
								)as tb3 ON tb1.HOSPCODE=tb3.HOSPCODE
								LEFT JOIN 
								(
								SELECT 
										 HOSPCODE as HOSPCODE,		
										 COUNT(*) as FM
										FROM  $table 
									WHERE SEX='2' AND  AGE >='".$age."'  
									GROUP BY HOSPCODE
								)as tb4 ON tb1.HOSPCODE=tb4.HOSPCODE 
								
								WHERE tb1.subdistid='".$tambon."'
								GROUP BY tb1.HOSPCODE
								UNION ALL
								
								SELECT 
										'' ,
										'รวม', 
										SUM(tb2.CC) as SUMMARY,
									SUM(tb3.M) as MALE,
										 SUM(tb4.FM) as FEMALE
										
								
								FROM(
									   SELECT 
										   co_village_loei.hospcode as HOSPCODE,
													 42co_office_loei.off_name as HOSPNAME,
													 co_village_loei.subdistid as subdistid 
									   FROM co_village_loei
									 LEFT OUTER JOIN 42co_office_loei  ON co_village_loei.hospcode=42co_office_loei.off_id
									   GROUP BY hospcode 
								) as tb1
								LEFT JOIN
								(
											SELECT 
									  HOSPCODE as HOSPCODE,
										COUNT(*) as CC
										FROM $table 
										WHERE AGE >='".$age."'		
									GROUP BY HOSPCODE 
								) as tb2 ON tb1.HOSPCODE=tb2.HOSPCODE
								LEFT JOIN 
								(
								   SELECT 
										 HOSPCODE as HOSPCODE,		
										COUNT(*) as M
										FROM  $table 
									WHERE SEX='1' AND  AGE >='".$age."' 
										GROUP BY HOSPCODE
								)as tb3 ON tb1.HOSPCODE=tb3.HOSPCODE
								LEFT JOIN 
								(
								SELECT 
										 HOSPCODE as HOSPCODE,		
										 COUNT(*) as FM
										FROM  $table 
									WHERE SEX='2' AND  AGE >='".$age."'  
									GROUP BY HOSPCODE
								)as tb4 ON tb1.HOSPCODE=tb4.HOSPCODE 
								
								WHERE tb1.subdistid='".$tambon."'");
		}
//กลุ่มวัยระดับ village
		public function GET_AGE_GROUP_VILL($table,$age,$hcode){
			$this->rs=mysql_query("SELECT 
										tb2.VHID,
										 tb1.VILLNAME,
									 
										CASE WHEN tb2.CC='' THEN '0' 
											 WHEN tb2.CC<>'' THEN tb2.CC
										ELSE '0' END AS SUMMARY,
										CASE WHEN tb3.M='' THEN '0' 
											 WHEN tb3.M<>'' THEN tb3.M
										ELSE '0' END AS MALE,
										CASE WHEN tb4.FM='' THEN '0' 
											 WHEN tb4.FM<>'' THEN tb4.FM
										ELSE '0' END AS FEMALE
								
								FROM(
									   SELECT 
											cvl.villid as VILLID,
													  cvl.villname as VILLNAME,
														cvl.hospcode as HOSPCODE
									   FROM co_village_loei as cvl
									 #INNER JOIN $table as ag on cvl.hospcode = ag.HOSPCODE AND cvl.villid = ag.VHID 
									 WHERE cvl.hospcode ='".$hcode."' 
									 ORDER BY cvl.hospcode
								) as tb1
								LEFT JOIN
								(
										SELECT 
									  HOSPCODE as HOSPCODE,
									  VHID as VHID,
										COUNT(*) as CC
										FROM $table 
										WHERE AGE >='".$age."'		
									GROUP BY VHID 
								) as tb2 ON tb1.VILLID=tb2.VHID
								LEFT JOIN 
								(
								   SELECT 
										  HOSPCODE as HOSPCODE,
									  VHID as VHID,		
										COUNT(*) as M
										FROM  $table 
									WHERE SEX='1' AND AGE >='".$age."' 
										GROUP BY VHID
								)as tb3 ON tb1.VILLID=tb3.VHID
								LEFT JOIN 
								(
								SELECT 
										 HOSPCODE as HOSPCODE,
									  VHID as VHID,			
										 COUNT(*) as FM
										FROM  $table 
									WHERE SEX='2' AND  AGE >='".$age."'  
									GROUP BY VHID
								)as tb4 ON tb1.VILLID=tb4.VHID 
								
								WHERE tb2.HOSPCODE='".$hcode."'
								UNION ALL
								SELECT 
										
										 '',
									 'รวม',
										SUM(tb2.CC) AS SUMMARY,
										sum(tb3.M) AS MALE,
										sum(tb4.FM) AS FEMALE
								
								FROM(
									   SELECT 
											cvl.villid as VILLID,
													  cvl.villname as VILLNAME,
														cvl.hospcode as HOSPCODE
									   FROM co_village_loei as cvl
									 #INNER JOIN $table as ag on cvl.hospcode = ag.HOSPCODE AND cvl.villid = ag.VHID 
									 WHERE cvl.hospcode ='".$hcode."' 
									 ORDER BY cvl.hospcode
								) as tb1
								LEFT JOIN
								(
										SELECT 
									  HOSPCODE as HOSPCODE,
									  VHID as VHID,
										COUNT(*) as CC
										FROM $table 
										WHERE AGE >='".$age."'		
									GROUP BY VHID 
								) as tb2 ON tb1.VILLID=tb2.VHID
								LEFT JOIN 
								(
								   SELECT 
										  HOSPCODE as HOSPCODE,
									  VHID as VHID,		
										COUNT(*) as M
										FROM  $table 
									WHERE SEX='1' AND AGE >='".$age."' 
										GROUP BY VHID
								)as tb3 ON tb1.VILLID=tb3.VHID
								LEFT JOIN 
								(
								SELECT 
										 HOSPCODE as HOSPCODE,
									  VHID as VHID,			
										 COUNT(*) as FM
										FROM  $table 
									WHERE SEX='2' AND  AGE >='".$age."'  
									GROUP BY VHID
								)as tb4 ON tb1.VILLID=tb4.VHID 
								
								WHERE tb2.HOSPCODE='".$hcode."'
								");
			}	
//กลุ่มวัยระดับ village
		public function GET_AGE_GROUP_CID($table,$age,$vhid){
			$this->rs=mysql_query("SELECT 
										zag.HOSPCODE as HOSPCODE,
										42co.off_name as HOSPNAME,
										zag.HPID as HPID,
										zag.CID as CID,
										pr.prename as PRENAME,
										CONCAT(zag.NAME,'  ',zag.LNAME) AS FNAME,
										zag.BIRTH as BIRTH,
										zag.AGE as AGE,
										zag.HOUSE as HOUSE,
										zag.villname as VNAME,
										ztb.tambonname as TBNAME,
										zam.AMP_NAME as AMPNAME,
										CASE  WHEN zag.VILLAGE='01' THEN '1' 
										  WHEN zag.VILLAGE='02' THEN '2'
											WHEN zag.VILLAGE='03' THEN '3'
											WHEN zag.VILLAGE='04' THEN '4'
											WHEN zag.VILLAGE='05' THEN '5'
											WHEN zag.VILLAGE='06' THEN '6'
											WHEN zag.VILLAGE='07' THEN '7'
											WHEN zag.VILLAGE='08' THEN '8'
											WHEN zag.VILLAGE='09' THEN '9'
										  ELSE zag.VILLAGE END AS VNO,
										CONCAT(zag.TYPEAREA,'=',ct.typeareaname) as TYPENAME
										FROM $table as zag
										LEFT OUTER JOIN cprename as pr ON zag.PRENAME = pr.id_prename
										LEFT OUTER JOIN z42_tambon as ztb ON CONCAT(zag.CHANGWAT,zag.AMPUR,zag.TAMBON)=CONCAT(ztb.tamboncodefull)
										LEFT OUTER JOIN z42_amp AS zam ON  CONCAT(zag.CHANGWAT,AMPUR)=CONCAT(zam.AMP_CODE)
										LEFT OUTER JOIN 42co_office_loei as 42co ON zag.HOSPCODE=42co.off_id
										LEFT OUTER JOIN ctypearea as ct ON zag.TYPEAREA=ct.typeareacode
										WHERE VHID ='".$vhid."' AND AGE >='".$age."'GROUP BY zag.CID ORDER BY zag.HOSPCODE
								");
			}		
////กลุ่มอายุ 0-5 ปี amp
        public function GET_AGE_GROUP_CHW_AMP($table){
			$this->rs=mysql_query("SELECT * FROM $table");
			}
//กลุ่มอายุ 0-5 ปี tambon
		public function GET_AGE_GROUP_CHW_TAMBON($table,$age_st,$age_end,$ampcode){
			$this->rs=mysql_query("SELECT 
								tb1.TBCODE,
								tb1.TBNAME,
								CASE WHEN tb2.CC='' THEN '0' 
									 WHEN tb2.CC<>'' THEN tb2.CC
								ELSE '0' END AS SUMMARY,
								CASE WHEN tb3.M='' THEN '0' 
									 WHEN tb3.M<>'' THEN tb3.M
								ELSE '0' END AS MALE,
								CASE WHEN tb4.FM='' THEN '0' 
									 WHEN tb4.FM<>'' THEN tb4.FM
								ELSE '0' END AS FEMALE
						
						FROM(
							   SELECT 
								 tambonname as TBNAME,
										tamboncodefull as TBCODE,
										ampurcode as AMPCODE
							   FROM z42_tambon
							   GROUP BY tamboncodefull 
						) as tb1
						LEFT JOIN
						(
								SELECT 
							  CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,
								COUNT(*) as CC
								FROM $table 
								WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON) 
						) as tb2 ON tb1.TBCODE=tb2.TBCODE
						LEFT JOIN 
						(
						   SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								COUNT(*) as M
								FROM  $table 
							WHERE SEX='1' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."' 
								GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb3 ON tb1.TBCODE=tb3.TBCODE 
						LEFT JOIN 
						(
						SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								 COUNT(*) as FM
								FROM  $table 
							WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb4 ON tb1.TBCODE=tb4.TBCODE 
						
						WHERE tb1.AMPCODE='".$ampcode."'
						GROUP BY tb1.TBCODE
						
						UNION ALL
						
						SELECT 
								'' ,
								'รวม', 
								SUM(tb2.CC) as SUMMARY,
								 SUM(tb3.M) as MALE,
								 SUM(tb4.FM) as FEMALE
								
						
						FROM(
							   SELECT 
								 tambonname as TBNAME,
										tamboncodefull as TBCODE,
										ampurcode as AMPCODE
							   FROM z42_tambon
							   GROUP BY tamboncodefull 
						) as tb1
						LEFT JOIN
						(
								SELECT 
							  CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,
								COUNT(*) as CC
								FROM $table 
								WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON) 
						) as tb2 ON tb1.TBCODE=tb2.TBCODE
						LEFT JOIN 
						(
						   SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								COUNT(*) as M
								FROM  $table 
							WHERE SEX='1' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."' 
								GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb3 ON tb1.TBCODE=tb3.TBCODE 
						LEFT JOIN 
						(
						SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								 COUNT(*) as FM
								FROM  $table 
							WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb4 ON tb1.TBCODE=tb4.TBCODE 
						
						WHERE tb1.AMPCODE='".$ampcode."'
						#GROUP BY tb1.TBCODE;");
				}
//กลุ่มอายุ 0-5 5-14 ปี PCU
		public function GET_AGE_GROUP_CHW_PCU($table,$age_st,$age_end,$tambon){
			$this->rs=mysql_query("
					          SELECT 
							tb1.HOSPCODE,
							tb1.HOSPNAME,
					
							CASE WHEN tb2.CC='' THEN '0' 
								 WHEN tb2.CC<>'' THEN tb2.CC
							ELSE '0' END AS SUMMARY,
							CASE WHEN tb3.M='' THEN '0' 
								 WHEN tb3.M<>'' THEN tb3.M
							ELSE '0' END AS MALE,
							CASE WHEN tb4.FM='' THEN '0' 
								 WHEN tb4.FM<>'' THEN tb4.FM
							ELSE '0' END AS FEMALE
					
					FROM(
						   SELECT 
							   co_village_loei.hospcode as HOSPCODE,
										 42co_office_loei.off_name as HOSPNAME,
										 co_village_loei.subdistid as subdistid 
						   FROM co_village_loei
						 LEFT OUTER JOIN 42co_office_loei  ON co_village_loei.hospcode=42co_office_loei.off_id
						   GROUP BY hospcode 
					) as tb1
					LEFT JOIN
					(
							SELECT 
						  HOSPCODE as HOSPCODE,
							COUNT(*) as CC
							FROM $table
							WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
						GROUP BY HOSPCODE 
					) as tb2 ON tb1.HOSPCODE=tb2.HOSPCODE
					LEFT JOIN 
					(
					   SELECT 
							 HOSPCODE as HOSPCODE,		
							COUNT(*) as M
							FROM  z42_age_group_vill_t 
						WHERE SEX='1' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."' 
							GROUP BY HOSPCODE
					)as tb3 ON tb1.HOSPCODE=tb3.HOSPCODE
					LEFT JOIN 
					(
					SELECT 
							 HOSPCODE as HOSPCODE,		
							 COUNT(*) as FM
							FROM  $table 
						WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
						GROUP BY HOSPCODE
					)as tb4 ON tb1.HOSPCODE=tb4.HOSPCODE 
					
					WHERE tb1.subdistid='".$tambon."'
					GROUP BY tb1.HOSPCODE
					UNION ALL
					
					SELECT 
							'' ,
							'รวม', 
							SUM(tb2.CC) as SUMMARY,
						SUM(tb3.M) as MALE,
							 SUM(tb4.FM) as FEMALE
							
					
					FROM(
						   SELECT 
							   co_village_loei.hospcode as HOSPCODE,
										 42co_office_loei.off_name as HOSPNAME,
										 co_village_loei.subdistid as subdistid 
						   FROM co_village_loei
						 LEFT OUTER JOIN 42co_office_loei  ON co_village_loei.hospcode=42co_office_loei.off_id
						   GROUP BY hospcode 
					) as tb1
					LEFT JOIN
					(
								SELECT 
						  HOSPCODE as HOSPCODE,
							COUNT(*) as CC
							FROM $table 
							WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
						GROUP BY HOSPCODE 
					) as tb2 ON tb1.HOSPCODE=tb2.HOSPCODE
					LEFT JOIN 
					(
					   SELECT 
							 HOSPCODE as HOSPCODE,		
							COUNT(*) as M
							FROM  $table 
						WHERE SEX='1' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."' 
							GROUP BY HOSPCODE
					)as tb3 ON tb1.HOSPCODE=tb3.HOSPCODE
					LEFT JOIN 
					(
					SELECT 
							 HOSPCODE as HOSPCODE,		
							 COUNT(*) as FM
							FROM  $table 
						WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
						GROUP BY HOSPCODE
					)as tb4 ON tb1.HOSPCODE=tb4.HOSPCODE 
					
					WHERE tb1.subdistid='".$tambon."'
			
			");
			
			}	
//	กลุ่มอายุ 0-5 5-14 ปี VILL และ 9-42 เดือน		
		public function GET_AGE_GROUP_CHW_VILL_M($table,$hcode,$age_st,$age_end){
		    $this->rs=mysql_query("
				SELECT 
						tb2.VHID,
						 tb1.VILLNAME,
					 
						CASE WHEN tb2.CC='' THEN '0' WHEN tb2.CC<>'' THEN tb2.CC ELSE '0' END AS SUMMARY,
						CASE WHEN tb3.M='' THEN '0' WHEN tb3.M<>'' THEN tb3.M ELSE '0' END AS MALE,
						CASE WHEN tb4.FM='' THEN '0' WHEN tb4.FM<>'' THEN tb4.FM ELSE '0' END AS FEMALE,
					CASE WHEN tb5.AGE_MONTH_MALE_M9='' THEN '0' WHEN tb5.AGE_MONTH_MALE_M9<>'' THEN tb5.AGE_MONTH_MALE_M9 ELSE '0' END AS AGE_MALE_M9,
						CASE WHEN tb6.AGE_MONTH_FEMALE_M9='' THEN '0' WHEN tb6.AGE_MONTH_FEMALE_M9<>'' THEN tb6.AGE_MONTH_FEMALE_M9 ELSE '0' END AS AGE_FEMALE_M9,
					CASE WHEN tb7.AGE_MONTH_MALE_M18='' THEN '0' WHEN tb7.AGE_MONTH_MALE_M18<>'' THEN tb7.AGE_MONTH_MALE_M18 ELSE '0' END AS AGE_MALE_M18,
						CASE WHEN tb8.AGE_MONTH_FEMALE_M18='' THEN '0' WHEN tb8.AGE_MONTH_FEMALE_M18<>'' THEN tb8.AGE_MONTH_FEMALE_M18 ELSE '0' END AS AGE_FEMALE_M18,
						CASE WHEN tb9.AGE_MONTH_MALE_M30='' THEN '0' WHEN tb9.AGE_MONTH_MALE_M30<>'' THEN tb9.AGE_MONTH_MALE_M30 ELSE '0' END AS AGE_MALE_M30,
						CASE WHEN tb10.AGE_MONTH_FEMALE_M30='' THEN '0' WHEN tb10.AGE_MONTH_FEMALE_M30<>'' THEN tb10.AGE_MONTH_FEMALE_M30 ELSE '0' END AS AGE_FEMALE_M30,
						CASE WHEN tb11.AGE_MONTH_MALE_M42='' THEN '0' WHEN tb11.AGE_MONTH_MALE_M42<>'' THEN tb11.AGE_MONTH_MALE_M42 ELSE '0' END AS AGE_MALE_M42,
						CASE WHEN tb12.AGE_MONTH_FEMALE_M42='' THEN '0' WHEN tb12.AGE_MONTH_FEMALE_M42<>'' THEN tb12.AGE_MONTH_FEMALE_M42 ELSE '0' END AS AGE_FEMALE_M42
				FROM(
					   SELECT 
							cvl.villid as VILLID,
									  cvl.villname as VILLNAME,
										cvl.hospcode as HOSPCODE
					   FROM co_village_loei as cvl
					 #INNER JOIN z42_age_group_vill_t as ag on cvl.hospcode = ag.HOSPCODE AND cvl.villid = ag.VHID 
					 WHERE cvl.hospcode ='".$hcode."' 
					 ORDER BY cvl.hospcode
				) as tb1
				LEFT JOIN
				(
						
						SELECT 
					  HOSPCODE as HOSPCODE,
					  VHID as VHID,
						COUNT(*) as CC
						FROM $table 
						WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
					GROUP BY VHID 
				) as tb2 ON tb1.VILLID=tb2.VHID
				LEFT JOIN 
				(
				   SELECT 
						  HOSPCODE as HOSPCODE,
					  VHID as VHID,		
						COUNT(*) as M
						FROM  $table 
					WHERE SEX='1' AND AGE BETWEEN '".$age_st."' AND '".$age_end."' 
						GROUP BY VHID
				)as tb3 ON tb1.VILLID=tb3.VHID
				LEFT JOIN 
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as FM
						FROM  $table 
					WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
					GROUP BY VHID
				)as tb4 ON tb1.VILLID=tb4.VHID 
				##
				LEFT JOIN 
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M9
						FROM  $table
					WHERE SEX='1' AND  AGE_MONTH='9'   
					GROUP BY VHID
				
				)as tb5 ON tb1.VILLID=tb5.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M9
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH='9'   
					GROUP BY VHID
				)as tb6 ON tb1.VILLID=tb6.VHID
				##
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M18
						FROM  $table
					WHERE SEX='1' AND  AGE_MONTH ='18'   
					GROUP BY VHID
				)as tb7 ON tb1.VILLID=tb7.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M18
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH ='18'   
					GROUP BY VHID
				)as tb8 ON tb1.VILLID=tb8.VHID
				LEFT JOIN
				##
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M30
						FROM  $table 
					WHERE SEX='1' AND  AGE_MONTH ='30'   
					GROUP BY VHID
				)as tb9 ON tb1.VILLID=tb9.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M30
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH ='30'   
					GROUP BY VHID
				)as tb10 ON tb1.VILLID=tb10.VHID
				######
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M42
						FROM  $table 
					WHERE SEX='1' AND  AGE_MONTH ='42'   
					GROUP BY VHID
				)as tb11 ON tb1.VILLID=tb11.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M42
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH ='42'   
					GROUP BY VHID
				)as tb12 ON tb1.VILLID=tb12.VHID
				
				WHERE tb2.HOSPCODE='".$hcode."'
				##########################################
				
				UNION ALL
				
				SELECT 
						
						 '',
					 'รวม',
						SUM(tb2.CC) AS SUMMARY,
						sum(tb3.M) AS MALE,
						sum(tb4.FM) AS FEMALE,
						sum(tb5.AGE_MONTH_MALE_M9) AS AGE_MALE_M9,
					sum(tb6.AGE_MONTH_FEMALE_M9) AS AGE_FEMALE_M9,
						sum(tb7.AGE_MONTH_MALE_M18) AS AGE_MALE_M18,
					sum(tb8.AGE_MONTH_FEMALE_M18) AS AGE_FEMALE_M18,
						sum(tb9.AGE_MONTH_MALE_M30) AS AGE_MALE_M30,
					sum(tb10.AGE_MONTH_FEMALE_M30) AS AGE_FEMALE_M30,
				   sum(tb11.AGE_MONTH_MALE_M42) AS AGE_MALE_M42,
						sum(tb12.AGE_MONTH_FEMALE_M42) AS AGE_FEMALE_M42
				
				
				
				
				
				FROM(
					   SELECT 
							cvl.villid as VILLID,
									  cvl.villname as VILLNAME,
										cvl.hospcode as HOSPCODE
					   FROM co_village_loei as cvl
					 WHERE cvl.hospcode ='".$hcode."' 
					 ORDER BY cvl.hospcode
				) as tb1
				LEFT JOIN
				(
						SELECT 
					  HOSPCODE as HOSPCODE,
					  VHID as VHID,
						COUNT(*) as CC
						FROM $table 
						WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
					GROUP BY VHID 
				) as tb2 ON tb1.VILLID=tb2.VHID
				LEFT JOIN 
				(
				   SELECT 
						  HOSPCODE as HOSPCODE,
					  VHID as VHID,		
						COUNT(*) as M
						FROM  $table
					WHERE SEX='1' AND AGE BETWEEN '".$age_st."' AND '".$age_end."' 
						GROUP BY VHID
				)as tb3 ON tb1.VILLID=tb3.VHID
				LEFT JOIN 
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as FM
						FROM  $table 
					WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
					GROUP BY VHID
				)as tb4 ON tb1.VILLID=tb4.VHID 
				LEFT JOIN 
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M9
						FROM  $table 
					WHERE SEX='1' AND  AGE_MONTH = '9'   
					GROUP BY VHID
				
				)as tb5 ON tb1.VILLID=tb5.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M9
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH = '9'   
					GROUP BY VHID
				)as tb6 ON tb1.VILLID=tb6.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M18
						FROM  $table 
					WHERE SEX='1' AND  AGE_MONTH = '18'   
					GROUP BY VHID
				)as tb7 ON tb1.VILLID=tb7.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M18
						FROM  $table
					WHERE SEX='2' AND  AGE_MONTH = '18'   
					GROUP BY VHID
				)as tb8 ON tb1.VILLID=tb8.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M30
						FROM  $table 
					WHERE SEX='1' AND  AGE_MONTH ='30'   
					GROUP BY VHID
				)as tb9 ON tb1.VILLID=tb9.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M30
						FROM  $table
					WHERE SEX='2' AND  AGE_MONTH ='30'   
					GROUP BY VHID
				)as tb10 ON tb1.VILLID=tb10.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_MALE_M42
						FROM  $table 
					WHERE SEX='1' AND  AGE_MONTH ='42'   
					GROUP BY VHID
				)as tb11 ON tb1.VILLID=tb11.VHID
				LEFT JOIN
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as AGE_MONTH_FEMALE_M42
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH ='42'   
					GROUP BY VHID
				)as tb12 ON tb1.VILLID=tb12.VHID
				WHERE tb2.HOSPCODE='".$hcode."'
			
			");
			}
//กลุ่มอายุ 5-14 ปี VILL
   public function GET_AGE_GROUP_CHW_VILL($table,$hcode,$age_st,$age_end){
	   $this->rs=mysql_query("
	           SELECT 
					tb2.VHID,
					 tb1.VILLNAME,
				 
					CASE WHEN tb2.CC='' THEN '0' 
						 WHEN tb2.CC<>'' THEN tb2.CC
					ELSE '0' END AS SUMMARY,
					CASE WHEN tb3.M='' THEN '0' 
						 WHEN tb3.M<>'' THEN tb3.M
					ELSE '0' END AS MALE,
					CASE WHEN tb4.FM='' THEN '0' 
						 WHEN tb4.FM<>'' THEN tb4.FM
					ELSE '0' END AS FEMALE
			
			FROM(
				   SELECT 
						cvl.villid as VILLID,
								  cvl.villname as VILLNAME,
									cvl.hospcode as HOSPCODE
				   FROM co_village_loei as cvl
				 #INNER JOIN z42_age_group_vill_t as ag on cvl.hospcode = ag.HOSPCODE AND cvl.villid = ag.VHID 
				 WHERE cvl.hospcode ='".$hcode."' 
				 ORDER BY cvl.hospcode
			) as tb1
			LEFT JOIN
			(
					SELECT 
				  HOSPCODE as HOSPCODE,
				  VHID as VHID,
					COUNT(*) as CC
					FROM $table 
					WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
				GROUP BY VHID 
			) as tb2 ON tb1.VILLID=tb2.VHID
			LEFT JOIN 
			(
			   SELECT 
					  HOSPCODE as HOSPCODE,
				  VHID as VHID,		
					COUNT(*) as M
					FROM  $table 
				WHERE SEX='1' AND AGE BETWEEN '".$age_st."' AND '".$age_end."' 
					GROUP BY VHID
			)as tb3 ON tb1.VILLID=tb3.VHID
			LEFT JOIN 
			(
			SELECT 
					 HOSPCODE as HOSPCODE,
				  VHID as VHID,			
					 COUNT(*) as FM
					FROM  $table 
				WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
				GROUP BY VHID
			)as tb4 ON tb1.VILLID=tb4.VHID 
			
			WHERE tb2.HOSPCODE='".$hcode."'
			UNION ALL
			SELECT 
					
					 '',
				 'รวม',
					SUM(tb2.CC) AS SUMMARY,
					sum(tb3.M) AS MALE,
					sum(tb4.FM) AS FEMALE
			
			FROM(
				   SELECT 
						cvl.villid as VILLID,
								  cvl.villname as VILLNAME,
									cvl.hospcode as HOSPCODE
				   FROM co_village_loei as cvl
				 #INNER JOIN z42_age_group_vill_t as ag on cvl.hospcode = ag.HOSPCODE AND cvl.villid = ag.VHID 
				 WHERE cvl.hospcode ='".$hcode."' 
				 ORDER BY cvl.hospcode
			) as tb1
			LEFT JOIN
			(
					SELECT 
				  HOSPCODE as HOSPCODE,
				  VHID as VHID,
					COUNT(*) as CC
					FROM $table 
					WHERE AGE BETWEEN '".$age_st."' AND '".$age_end."'		
				GROUP BY VHID 
			) as tb2 ON tb1.VILLID=tb2.VHID
			LEFT JOIN 
			(
			   SELECT 
					  HOSPCODE as HOSPCODE,
				  VHID as VHID,		
					COUNT(*) as M
					FROM  $table 
				WHERE SEX='1' AND AGE BETWEEN '".$age_st."' AND '".$age_end."' 
					GROUP BY VHID
			)as tb3 ON tb1.VILLID=tb3.VHID
			LEFT JOIN 
			(
			SELECT 
					 HOSPCODE as HOSPCODE,
				  VHID as VHID,			
					 COUNT(*) as FM
					FROM  $table 
				WHERE SEX='2' AND  AGE BETWEEN '".$age_st."' AND '".$age_end."'  
				GROUP BY VHID
			)as tb4 ON tb1.VILLID=tb4.VHID 
			
			WHERE tb2.HOSPCODE='".$hcode."'");
	   
	   }	
////กลุ่มอายุ 0-5 5-14 ปี CID
	   public function GET_AGE_GROUP_CHW_CID($table,$vhid,$age_st,$age_end){
		   $this->rs=mysql_query("
		   		SELECT 
				
				zag.HOSPCODE as HOSPCODE,
				42co.off_name as HOSPNAME,
				zag.HPID as HPID,
				zag.CID as CID,
				pr.prename as PRENAME,
				CONCAT(zag.NAME,'  ',zag.LNAME) AS FNAME,
				zag.BIRTH as BIRTH,
				zag.AGE as AGE,
				zag.AGE_MONTH as AGE_MONTH,
				zag.HOUSE as HOUSE,
				zag.villname as VNAME,
				ztb.tambonname as TBNAME,
				zam.AMP_NAME as AMPNAME,
				CASE  WHEN zag.VILLAGE='01' THEN '1' 
				  WHEN zag.VILLAGE='02' THEN '2'
					WHEN zag.VILLAGE='03' THEN '3'
					WHEN zag.VILLAGE='04' THEN '4'
					WHEN zag.VILLAGE='05' THEN '5'
					WHEN zag.VILLAGE='06' THEN '6'
					WHEN zag.VILLAGE='07' THEN '7'
					WHEN zag.VILLAGE='08' THEN '8'
					WHEN zag.VILLAGE='09' THEN '9'
				  ELSE zag.VILLAGE END AS VNO,
				CONCAT(zag.TYPEAREA,'=',ct.typeareaname) as TYPENAME
				FROM $table as zag
				LEFT OUTER JOIN cprename as pr ON zag.PRENAME = pr.id_prename
				LEFT OUTER JOIN z42_tambon as ztb ON CONCAT(zag.CHANGWAT,zag.AMPUR,zag.TAMBON)=CONCAT(ztb.tamboncodefull)
				LEFT OUTER JOIN z42_amp AS zam ON  CONCAT(zag.CHANGWAT,AMPUR)=CONCAT(zam.AMP_CODE)
				LEFT OUTER JOIN 42co_office_loei as 42co ON zag.HOSPCODE=42co.off_id
				LEFT OUTER JOIN ctypearea as ct ON zag.TYPEAREA=ct.typeareacode
				WHERE VHID ='".$vhid."' AND AGE BETWEEN'".$age_st."' AND '".$age_end."' GROUP BY zag.CID ORDER BY zag.AGE_MONTH;
		   
		   ");
		   }		
///////////////////////
////กลุ่มอายุ 9เดือน amp
        public function GET_AGE_GROUP_CHM_AMP($table){
			$this->rs=mysql_query("SELECT * FROM $table");
			}
//กลุ่มอายุ 9เดือน tambon
		public function GET_AGE_GROUP_CHM_TAMBON($table,$age_m,$ampcode){
			$this->rs=mysql_query("SELECT 
								tb1.TBCODE,
								tb1.TBNAME,
								CASE WHEN tb2.CC='' THEN '0' 
									 WHEN tb2.CC<>'' THEN tb2.CC
								ELSE '0' END AS SUMMARY,
								CASE WHEN tb3.M='' THEN '0' 
									 WHEN tb3.M<>'' THEN tb3.M
								ELSE '0' END AS MALE,
								CASE WHEN tb4.FM='' THEN '0' 
									 WHEN tb4.FM<>'' THEN tb4.FM
								ELSE '0' END AS FEMALE
						
						FROM(
							   SELECT 
								 tambonname as TBNAME,
										tamboncodefull as TBCODE,
										ampurcode as AMPCODE
							   FROM z42_tambon
							   GROUP BY tamboncodefull 
						) as tb1
						LEFT JOIN
						(
								SELECT 
							  CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,
								COUNT(*) as CC
								FROM $table 
								WHERE AGE_MONTH ='".$age_m."'	
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON) 
						) as tb2 ON tb1.TBCODE=tb2.TBCODE
						LEFT JOIN 
						(
						   SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								COUNT(*) as M
								FROM  $table 
							WHERE SEX='1' AND  AGE_MONTH ='".$age_m."'	 
								GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb3 ON tb1.TBCODE=tb3.TBCODE 
						LEFT JOIN 
						(
						SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								 COUNT(*) as FM
								FROM  $table 
							WHERE SEX='2' AND  AGE_MONTH ='".$age_m."'	 
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb4 ON tb1.TBCODE=tb4.TBCODE 
						
						WHERE tb1.AMPCODE='".$ampcode."'
						GROUP BY tb1.TBCODE
						
						UNION ALL
						
						SELECT 
								'' ,
								'รวม', 
								SUM(tb2.CC) as SUMMARY,
								 SUM(tb3.M) as MALE,
								 SUM(tb4.FM) as FEMALE
								
						
						FROM(
							   SELECT 
								 tambonname as TBNAME,
										tamboncodefull as TBCODE,
										ampurcode as AMPCODE
							   FROM z42_tambon
							   GROUP BY tamboncodefull 
						) as tb1
						LEFT JOIN
						(
								SELECT 
							  CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,
								COUNT(*) as CC
								FROM $table 
								WHERE AGE_MONTH ='".$age_m."'			
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON) 
						) as tb2 ON tb1.TBCODE=tb2.TBCODE
						LEFT JOIN 
						(
						   SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								COUNT(*) as M
								FROM  $table 
							WHERE SEX='1' AND  AGE_MONTH ='".$age_m."'	 
								GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb3 ON tb1.TBCODE=tb3.TBCODE 
						LEFT JOIN 
						(
						SELECT 
								 CONCAT(CHANGWAT,AMPUR,TAMBON) as TBCODE,		
								 COUNT(*) as FM
								FROM  $table 
							WHERE SEX='2' AND  AGE_MONTH ='".$age_m."'	  
							GROUP BY CONCAT(CHANGWAT,AMPUR,TAMBON)
						)as tb4 ON tb1.TBCODE=tb4.TBCODE 
						
						WHERE tb1.AMPCODE='".$ampcode."'
						#GROUP BY tb1.TBCODE;");
				}			
	//กลุ่มอายุ 9เดือน PCU
		public function GET_AGE_GROUP_CHM_PCU($table,$age_m,$tambon){
			$this->rs=mysql_query("
					          SELECT 
							tb1.HOSPCODE,
							tb1.HOSPNAME,
					
							CASE WHEN tb2.CC='' THEN '0' 
								 WHEN tb2.CC<>'' THEN tb2.CC
							ELSE '0' END AS SUMMARY,
							CASE WHEN tb3.M='' THEN '0' 
								 WHEN tb3.M<>'' THEN tb3.M
							ELSE '0' END AS MALE,
							CASE WHEN tb4.FM='' THEN '0' 
								 WHEN tb4.FM<>'' THEN tb4.FM
							ELSE '0' END AS FEMALE
					
					FROM(
						   SELECT 
							   co_village_loei.hospcode as HOSPCODE,
										 42co_office_loei.off_name as HOSPNAME,
										 co_village_loei.subdistid as subdistid 
						   FROM co_village_loei
						 LEFT OUTER JOIN 42co_office_loei  ON co_village_loei.hospcode=42co_office_loei.off_id
						   GROUP BY hospcode 
					) as tb1
					LEFT JOIN
					(
							SELECT 
						  HOSPCODE as HOSPCODE,
							COUNT(*) as CC
							FROM $table
							WHERE AGE_MONTH ='".$age_m."'		
						GROUP BY HOSPCODE 
					) as tb2 ON tb1.HOSPCODE=tb2.HOSPCODE
					LEFT JOIN 
					(
					   SELECT 
							 HOSPCODE as HOSPCODE,		
							COUNT(*) as M
							FROM  $table 
						WHERE SEX='1' AND  AGE_MONTH ='".$age_m."' 
							GROUP BY HOSPCODE
					)as tb3 ON tb1.HOSPCODE=tb3.HOSPCODE
					LEFT JOIN 
					(
					SELECT 
							 HOSPCODE as HOSPCODE,		
							 COUNT(*) as FM
							FROM  $table 
						WHERE SEX='2' AND  AGE_MONTH ='".$age_m."'  
						GROUP BY HOSPCODE
					)as tb4 ON tb1.HOSPCODE=tb4.HOSPCODE 
					
					WHERE tb1.subdistid='".$tambon."'
					GROUP BY tb1.HOSPCODE
					UNION ALL
					
					SELECT 
							'' ,
							'รวม', 
							SUM(tb2.CC) as SUMMARY,
						SUM(tb3.M) as MALE,
							 SUM(tb4.FM) as FEMALE
							
					
					FROM(
						   SELECT 
							   co_village_loei.hospcode as HOSPCODE,
										 42co_office_loei.off_name as HOSPNAME,
										 co_village_loei.subdistid as subdistid 
						   FROM co_village_loei
						 LEFT OUTER JOIN 42co_office_loei  ON co_village_loei.hospcode=42co_office_loei.off_id
						   GROUP BY hospcode 
					) as tb1
					LEFT JOIN
					(
								SELECT 
						  HOSPCODE as HOSPCODE,
							COUNT(*) as CC
							FROM $table 
							WHERE AGE_MONTH ='".$age_m."'		
						GROUP BY HOSPCODE 
					) as tb2 ON tb1.HOSPCODE=tb2.HOSPCODE
					LEFT JOIN 
					(
					   SELECT 
							 HOSPCODE as HOSPCODE,		
							COUNT(*) as M
							FROM  $table 
						WHERE SEX='1' AND  AGE_MONTH ='".$age_m."'
							GROUP BY HOSPCODE
					)as tb3 ON tb1.HOSPCODE=tb3.HOSPCODE
					LEFT JOIN 
					(
					SELECT 
							 HOSPCODE as HOSPCODE,		
							 COUNT(*) as FM
							FROM  $table 
						WHERE SEX='2' AND AGE_MONTH ='".$age_m."'  
						GROUP BY HOSPCODE
					)as tb4 ON tb1.HOSPCODE=tb4.HOSPCODE 
					
					WHERE tb1.subdistid='".$tambon."'
			
			");
			
			}	
	//	กลุ่มอายุ 9 เดือน vill		
		public function GET_AGE_GROUP_CHM_VILL($table,$hcode,$age_m){
		    $this->rs=mysql_query("
				SELECT 
						tb2.VHID,
						 tb1.VILLNAME,
					 
						CASE WHEN tb2.CC='' THEN '0' WHEN tb2.CC<>'' THEN tb2.CC ELSE '0' END AS SUMMARY,
						CASE WHEN tb3.M='' THEN '0' WHEN tb3.M<>'' THEN tb3.M ELSE '0' END AS MALE,
						CASE WHEN tb4.FM='' THEN '0' WHEN tb4.FM<>'' THEN tb4.FM ELSE '0' END AS FEMALE
						FROM(
					   SELECT 
							cvl.villid as VILLID,
									  cvl.villname as VILLNAME,
										cvl.hospcode as HOSPCODE
					   FROM co_village_loei as cvl
					 #INNER JOIN z42_age_group_vill_t as ag on cvl.hospcode = ag.HOSPCODE AND cvl.villid = ag.VHID 
					 WHERE cvl.hospcode ='".$hcode."' 
					 ORDER BY cvl.hospcode
				) as tb1
				LEFT JOIN
				(
						
						SELECT 
					  HOSPCODE as HOSPCODE,
					  VHID as VHID,
						COUNT(*) as CC
						FROM $table 
						WHERE AGE_MONTH ='".$age_m."'		
					GROUP BY VHID 
				) as tb2 ON tb1.VILLID=tb2.VHID
				LEFT JOIN 
				(
				   SELECT 
						  HOSPCODE as HOSPCODE,
					  VHID as VHID,		
						COUNT(*) as M
						FROM  $table 
					WHERE SEX='1' AND AGE_MONTH ='".$age_m."' 
						GROUP BY VHID
				)as tb3 ON tb1.VILLID=tb3.VHID
				LEFT JOIN 
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as FM
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH ='".$age_m."'  
					GROUP BY VHID
				)as tb4 ON tb1.VILLID=tb4.VHID 
				##
				WHERE tb2.HOSPCODE='".$hcode."'
				##########################################
				
				UNION ALL
				
				SELECT 
						
						 '',
					 'รวม',
						SUM(tb2.CC) AS SUMMARY,
						sum(tb3.M) AS MALE,
						sum(tb4.FM) AS FEMALE	
				FROM(
					   SELECT 
							cvl.villid as VILLID,
									  cvl.villname as VILLNAME,
										cvl.hospcode as HOSPCODE
					   FROM co_village_loei as cvl
					 WHERE cvl.hospcode ='".$hcode."' 
					 ORDER BY cvl.hospcode
				) as tb1
				LEFT JOIN
				(
						SELECT 
					  HOSPCODE as HOSPCODE,
					  VHID as VHID,
						COUNT(*) as CC
						FROM $table 
						WHERE AGE_MONTH ='".$age_m."' 		
					GROUP BY VHID 
				) as tb2 ON tb1.VILLID=tb2.VHID
				LEFT JOIN 
				(
				   SELECT 
						  HOSPCODE as HOSPCODE,
					  VHID as VHID,		
						COUNT(*) as M
						FROM  $table
					WHERE SEX='1' AND AGE_MONTH ='".$age_m."'  
						GROUP BY VHID
				)as tb3 ON tb1.VILLID=tb3.VHID
				LEFT JOIN 
				(
				SELECT 
						 HOSPCODE as HOSPCODE,
					  VHID as VHID,			
						 COUNT(*) as FM
						FROM  $table 
					WHERE SEX='2' AND  AGE_MONTH ='".$age_m."'  
					GROUP BY VHID
				)as tb4 ON tb1.VILLID=tb4.VHID 
			
				WHERE tb2.HOSPCODE='".$hcode."'
			
			");
			}	
	////กลุ่มอายุ 9 เดือน CID
	   public function GET_AGE_GROUP_CHM_CID($table,$vhid,$age_m){
		   $this->rs=mysql_query("
		   		SELECT 
				
				zag.HOSPCODE as HOSPCODE,
				42co.off_name as HOSPNAME,
				zag.HPID as HPID,
				zag.CID as CID,
				pr.prename as PRENAME,
				CONCAT(zag.NAME,'  ',zag.LNAME) AS FNAME,
				zag.BIRTH as BIRTH,
				zag.AGE as AGE,
				zag.AGE_MONTH as AGE_MONTH,
				zag.HOUSE as HOUSE,
				zag.villname as VNAME,
				ztb.tambonname as TBNAME,
				zam.AMP_NAME as AMPNAME,
				CASE  WHEN zag.VILLAGE='01' THEN '1' 
				  WHEN zag.VILLAGE='02' THEN '2'
					WHEN zag.VILLAGE='03' THEN '3'
					WHEN zag.VILLAGE='04' THEN '4'
					WHEN zag.VILLAGE='05' THEN '5'
					WHEN zag.VILLAGE='06' THEN '6'
					WHEN zag.VILLAGE='07' THEN '7'
					WHEN zag.VILLAGE='08' THEN '8'
					WHEN zag.VILLAGE='09' THEN '9'
				  ELSE zag.VILLAGE END AS VNO,
				CONCAT(zag.TYPEAREA,'=',ct.typeareaname) as TYPENAME
				FROM $table as zag
				LEFT OUTER JOIN cprename as pr ON zag.PRENAME = pr.id_prename
				LEFT OUTER JOIN z42_tambon as ztb ON CONCAT(zag.CHANGWAT,zag.AMPUR,zag.TAMBON)=CONCAT(ztb.tamboncodefull)
				LEFT OUTER JOIN z42_amp AS zam ON  CONCAT(zag.CHANGWAT,AMPUR)=CONCAT(zam.AMP_CODE)
				LEFT OUTER JOIN 42co_office_loei as 42co ON zag.HOSPCODE=42co.off_id
				LEFT OUTER JOIN ctypearea as ct ON zag.TYPEAREA=ct.typeareacode
				WHERE VHID ='".$vhid."' AND AGE_MONTH ='".$age_m."'  GROUP BY zag.CID ORDER BY zag.AGE_MONTH;
		   
		   ");
		   }	
		   
		   public function TEST($table){
			   $this->rs=mysql_query("select * from $table");
			   } 			
//main
}	
		

?>

