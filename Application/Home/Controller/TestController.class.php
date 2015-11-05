<?php
namespace Home\Controller;
use OT\DataDictionary;


class TestController extends HomeController {
	
    public function index(){
        header("Content-Type:text/html;charset=utf-8");
    	echo '<h1>数据模型测试</h1><hr/>';
    	
    	$fun = "testMediaArtic";
        $funName = "getArtic";

    	echo "<h2>数据模型：'$fun'</h2>";
    	echo "<h2>函数名：'$funName'</h2>";
    	var_dump($this->$fun($funName));
        
        echo'<abbr title="British Broadcasting Corporation">BBC</abbr><br>
        <acronym title ="中国人民共和国">中国</aronym><hr/>';

        echo'衣带渐宽终不悔，<blockquote><p>为伊消得人憔悴</p></blockquote><hr/>';

        echo'本书衣带渐宽终不悔，为伊消得人憔悴<hr/><address>cheng1483@163.com</address><br/>';

        echo'<bdo dir="ltr">文字显示顺序</bdo><br/><bdo dir="rtl">文字显示顺序</bdo><br/>';

        $arrayName = array('一','二', '三', '四', '五', '六', '七' );
        for ($i=0; $i <7 ; $i++) { 
           
            echo '<p><font size="'.($i+1).'">样式'.$arrayName[$i].'</font></p>';
        }

        for ($i=0; $i <7 ; $i++) { 
           
            echo '<p><font size="+'.($i+1).'">样式'.$arrayName[$i].'</font></p>';
        }

        echo'<hr/>';


    }

    /**
     * 测试BannerList模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
    private function testBannerList($funName)
    {
    	$returnData = null;
    	$Banner = D('BannerList');
    	switch ($funName) {
    		case 'lists':
    			$returnData = $Banner->lists(1);
                break;
            case 'listCount':
                $returnData = $Banner->listCount(0);
                break;
            case 'updates':
                $data = array('title' =>'12345' ,'img' =>'http://baidu.com/wwwroot/index.php' ,'sort' => '2');
                $returnData = $Banner->updates(1,$data);
                break;
            case 'addData':
                $data = array('type'=>2,'group' =>1 ,'title' =>'从来都是一个小小的世界' ,'img' =>'http://baidu.com/wwwroot/index.php' ,'url' => 'http://baidu.com/wwwroot/index.php');
                $returnData = $Banner->addData($data['type'],$data['group'],$data['title'],$data['url'],$data['img']);
                break;
            case 'deleteDate':
                $returnData = $Banner->deleteDate('2');
                break;
    		default:
    			# code...
    			break;
    	}

    	return $returnData;
    }

    /**
     * 测试Channel模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
   private function testChannel($funName)
   {
        $returnData = null;
        $Channel = D('Channel');
        switch ($funName) {
            case 'lists':
                $returnData = $Channel->lists();
                break;
            
             case 'selectData':
                $data = array('url' => 'Auditorium/index' );
                $returnData = $Channel->selectData($data);
                break;

            default:
                # code...
                break;
        }

        return $returnData;
   }

     /**
     * 测试Config模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
   private function testConfig($funName)
   {
        $returnData = null;
        $Config = D('Config');
        switch ($funName) {
            case 'getAboutUslists':
                $returnData = $Config->getAboutUslists();
                break;
            default:
                # code...
                break;
        }

        return $returnData;
   }

    /**
     * 测试Config模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
   private function testFriendlink($funName)
   {
        $returnData = null;
        $Friendlink = D('Friendlink');
        switch ($funName) {
            case 'friendlinkLists':
                $returnData = $Friendlink->friendlinkLists();
                break;
            default:
                # code...
                break;
        }

        return $returnData;
   }


    /**
     * 测试ResourceTab模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
   private function testResourceTab($funName)
   {
        $returnData = null;
        $Friendlink = D('ResourceTab');
        switch ($funName) {
            case 'addTab':
             $data[] = array('name' =>'马克思主义基本概论' ,'type' => 1 ,'features' => 1  );
             $data[] = array('name' =>'毛泽东思想和中国特色社会主义理论体系概论' ,'type' => 1 ,'features' => 1  ); 
             $data[] = array('name' =>'中国近现代史纲要' ,'type' => 1 ,'features' => 1  ); 
             $data[] = array('name' =>'思想道德修养与法律基础' ,'type' => 1 ,'features' => 1  ); 
             $data[] = array('name' =>'形势与政策' ,'type' => 1 ,'features' => 1  );

            foreach ($data as $key => $value) {
                # code...
                $returnData = $Friendlink->addTab($value['name'],$value['type'],$value['features']);
            }
                
                break;

            case 'getTablists':
  
                $returnData = $Friendlink->getTablists(1);

                break;
                
            default:
                # code...
                break;
        }

        return $returnData;
   }

    /**
     * 测试Resource模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
   private function testResource($funName)
   {
        $returnData = null;
        $fun = D('Resource');
        switch ($funName) {
            case 'addReturn':
                $data[] = array("title"=>"特色社团1", "type"=>1, "group"=>2, "tab"=>1, "img"=>"/carousel/association.jpg","video"=>"234","authority"=>1,"set"=>"123");
                $data[] = array("title"=>"摄影基础2", "type"=>1, "group"=>2, "tab"=>1, "img"=>"/carousel/photography.jpg","video"=>"234","authority"=>1,"set"=>"123");
                $data[] = array("title"=>"社会主义理论3", "type"=>1, "group"=>2, "tab"=>2, "img"=>"/carousel/ebook.jpg","video"=>"234","authority"=>1,"set"=>"123");
                $data[] = array("title"=>"传承与理论4", "type"=>1, "group"=>2, "tab"=>2, "img"=>"/carousel/photography.jpg","video"=>"234","authority"=>1,"set"=>"123");
                $data[] = array("title"=>"社会主义理论5", "type"=>1, "group"=>2, "tab"=>1, "img"=>"/carousel/ebook.jpg","video"=>"234","authority"=>1,"set"=>"123");
                $data[] = array("title"=>"传承与理论6", "type"=>1, "group"=>2, "tab"=>2, "img"=>"/carousel/photography.jpg","video"=>"234","authority"=>1,"set"=>"123");
                $data[] = array("title"=>"社会主义理论7", "type"=>1, "group"=>2, "tab"=>3, "img"=>"/carousel/ebook.jpg","video"=>"234","authority"=>1,"set"=>"123");
                $data[] = array("title"=>"传承与理论8", "type"=>1, "group"=>2, "tab"=>4, "img"=>"/carousel/photography.jpg","video"=>"234","authority"=>1,"set"=>"123");
            foreach ($data as $key => $value) {
                # code...
                var_dump($returnData);
                $returnData = $fun->$funName($value['title'],$value['type'],$value['group'],$value['tab'],$value['img'],$value['video'],$value['authority'],$value['set']);
                
            }
                
                break;

            case 'getAuditoriumList':
  
                $returnData = $fun->$funName();

                break;
            
            case 'getResourcesList':
  
                $returnData = $fun->$funName(1,'2,8');

                break;

            case 'getInformationList':
  
                $returnData = $fun->$funName('1,6');

                break;
                
            default:
                # code...
                break;
        }

        return $returnData;
   }

    /**
     * 测试Resource模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
   private function testPersonnelData($funName)
   {
        $returnData = null;
        $fun = D('PersonnelData');
        switch ($funName) {
            case 'addPersonnel':

                $data[] = array("name"=>"李彦宏1", "type"=>2, "company"=>"百度公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"马化腾2", "type"=>2, "company"=>"腾讯公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"赵军3", "type"=>2, "company"=>"360公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"马云4", "type"=>2, "company"=>"淘宝公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"李彦宏5", "type"=>2, "company"=>"百度公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"马化腾6", "type"=>2, "company"=>"腾讯公司", "synopsis"=>"/carousel/association.jpg",);
                
                $data[] = array("name"=>"专家1", "type"=>3, "company"=>"百度公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"专家2", "type"=>3, "company"=>"腾讯公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"专家3", "type"=>3, "company"=>"360公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"专家4", "type"=>3, "company"=>"淘宝公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"专家5", "type"=>3, "company"=>"百度公司", "synopsis"=>"/carousel/association.jpg",);
                $data[] = array("name"=>"专家6", "type"=>3, "company"=>"腾讯公司", "synopsis"=>"/carousel/association.jpg",);
                
            foreach ($data as $key => $value) {
                var_dump($returnData);
                $returnData = $fun->$funName($value['name'],$value['type'],$value['company'],$value['synopsis']);
                
            }
                
                break;

            case 'getAuditoriumList':
                $returnData = $fun->$funName();

                break;
            
            case 'getSuccessPeople':
                $returnData = $fun->$funName('2,4');

                break;

            case 'getFieldExpert':
                $returnData = $fun->$funName('2,4');

                break;
            default:
                # code...
                break;
        }

        return $returnData;
   }


    /**
     * 测试MediaData模型
     * @param  string  $funName   方法名字
     * @return array              查询结果
     */
   private function testMediaData($funName)
   {
        $returnData = null;
        $fun = D('MediaData');
        switch ($funName) {
            //addReturn($type, $group, $title, $synopsis, $img)
            case 'addReturn':

                //学院新闻
                $data[] = array( "type"=>2, "group"=>1, "title"=>"《思修道德修养与法律基础》教学大纲" );
                $data[] = array( "type"=>2, "group"=>1, "title"=>"《毛泽东思想和中国特色社会主义理论体系概论》教学大纲");
                $data[] = array( "type"=>2, "group"=>1, "title"=>"《马克思主义基本原理概论》教学大纲");
                $data[] = array( "type"=>2, "group"=>1, "title"=>"《中国近现代史纲要》教学大纲");
                
                $data[] = array( "type"=>2, "group"=>2, "title"=>"情景教学法简介");
                $data[] = array( "type"=>2, "group"=>2, "title"=>"思政课情景剧教学实施过程流程图");
                $data[] = array( "type"=>2, "group"=>2, "title"=>"思修剧剧本 大学生活--考试风云");
               
                //通知
                $data[] = array( "type"=>2, "group"=>3, "title"=>"教学评价 简介");
                $data[] = array( "type"=>2, "group"=>3, "title"=>"教学成果");
                $data[] = array( "type"=>2, "group"=>3, "title"=>"教学评价");
                

            foreach ($data as $key => $value) {
                var_dump($returnData);
                $returnData = $fun->$funName($value['type'],$value['group'],$value['title'],$value['synopsis'],$value['img']);
                
            }
                
                break;

            case 'getNewsList':
                $returnData = $fun->$funName();

                break;
            
            case 'getPicturesShow':
                $returnData = $fun->$funName(4);

                break;
                
            case 'getEducationList':
                $returnData = $fun->$funName(1);

                break;

            case 'getNewsPage':
                $returnData = $fun->$funName();

                break;
            default:
                # code...
                break;
        }

        return $returnData;
   }

   
   private function testMediaArtic($funName)
   {
        $returnData = null;
        $fun = D('MediaArticle');
        switch ($funName) {
            //addReturn($type, $group, $title, $synopsis, $img)
            case 'addReturn':
            
            $MediaData = D('MediaData');
            $rData = $MediaData ->getNewsList(); 
            //var_dump($rData);  
            $data[]='<p class="Custom_UnionStyle" align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="http://news.tju.edu.cn/zx/ky/201510/W020151012611584761949.jpg" width="800" height="800"></p>
        <p class="Custom_UnionStyle">　　本站讯（通讯员 郭帅）9月24至29日，生命科学学院派出代表队参加国际遗传工程机器设计竞赛（International Genetically Engineered Machine Competition，iGEM），队伍从全球的280多支参赛队伍中脱颖而出，共获得Best New Application Project、Best New Basic Part两个单项第一，一块金牌，以及Best New Composite Part提名奖。</p>
        <p class="Custom_UnionStyle">　　生命科学学院首次指导队伍参加比赛，参赛学生来自生命科学学院（王镐锋、韩博文、刘嘉舒、李宇辰、赵晴、汪洋、胡金鑫、宗俊杰）、化工学院（鲍东琪、迟恒、陈泽翔、韩轩、董雪梅、李树斌、张雨薇）、求是学部（邵可同、喻俊杰、王画、殷翔宇、彭一格、王晨茂）等。此代表队由生命科学学院杨海涛教授指导，王泽方老师协助指导，该项目以一种蛋白实现多种科研与生活方面的应用——芯片固定、蛋白纯化以及塑料降解，对蛋白的改造也让几项应用的商业化成为可能。参赛队员们利用寒暑假及节假日等休息时间，完成了文献检索，定题，设计，实验，建模，实践，网页制作等大量工作，反复讨论项目细节，不断改进与创新。最终在国际比赛中展现了我校本科生的精神风貌与精彩的科研成果。</p>
        <p class="Custom_UnionStyle">　　此次获得两个单项第一和一块金牌，不仅是对参赛队伍连日辛苦工作的肯定，更是向世界展示了天大学子的科研热情和创新精神。准备参赛的历程为本科生科技创新提供了挑战与锻炼的平台，开创性的成绩是为母校天津大学120周年华诞献上的最佳贺礼！</p>
        <p class="Custom_UnionStyle">　　iGEM始于2005年，每年由美国麻省理工学院（Massachusetts Institute of Technology，MIT）主办，是合成生物学（Synthetic Biology）领域的最高国际性学术竞赛。合成生物学试图重新设计现有的天然的生物系统，或是设计和构建人工生物组件和系统，其目的在于通过了解天然生物体系的运作机理来创造全新的生物体系。参赛的包括了哈佛大学、耶鲁大学、牛津大学、剑桥大学、麻省理工学院等世界顶尖学府派出的代表队。</p>
        <p class="Custom_UnionStyle" align="right">　　（编辑 彭莉 学生编辑 李田田）</p>';
            $data[]='<h3 style="text-align: center;">
  聚青春 &nbsp; 塑英才</h3>
<h3 style="text-align: center;">
  学院成功承办2015年天津市青工职业技能大赛</h3>
<div>
  <strong>&nbsp; &nbsp; &nbsp; &nbsp;（图文/团委通讯员 金轶皓）</strong>8月28、29日，天津市青工职业技能大赛暨第十一届“振兴杯”全国青年职业技能大赛天津赛区选拔赛在学院成功举行。</div>
<div>
  &nbsp; &nbsp; &nbsp; &nbsp;团中央城市部部长郭美荐、团市委副书记方伟、天津市人社局副局长、天津广播电视大学党委书记于茂东、天津中环电子信息集团有限公司纪委书记陈良、团市委青工部部长段海鹰等领导莅临现场指导工作，学院党委书记陈昀陪同考察。</div>
<div style="text-align: center;">
  <img alt="" src="http://www.tjdz.net/uploads/allimg/150922/3-15092210322Y43.jpg" style="width: 553px; height: 311px;"></div>
<div style="text-align: center;">
  建筑结构设计师项目实操比赛现场</div>
<div style="text-align: center;">
  <img alt="" src="http://www.tjdz.net/uploads/allimg/150922/3-1509221032391Q.jpg" style="width: 553px; height: 369px;"></div>
<div style="text-align: center;">
  快递业务员项目比赛现场</div>
<div style="text-align: center;">
  <img alt="" src="http://www.tjdz.net/uploads/allimg/150922/3-150922103250305.jpg" style="width: 554px; height: 306px;"></div>
<div style="text-align: center;">
  电子商务师项目答辩现场</div>
<div>
  &nbsp; &nbsp; &nbsp; &nbsp;今年，学院承办了电子商务师、建筑结构设计师和快递业务员三个赛项，并选派计算机应用技术系王蓓和王佳两位教师参加电子商务师赛项比赛。近年来，学院教师参加青工技能大赛成绩骄人，有3位教师荣获天津市五一劳动奖章和新长征突击手称号。</div>
<div>
  &nbsp;</div>';
            $data[]='<div class="Custom_UnionStyle">
<p>　　<span>“如果用一句话来概括这部交响曲的内涵，那就是作者对‘独立之精神、自由之思想’的呼唤。”尽管，冯公让并不愿意用文字来更多地形容他创作的首部交响乐作品，因为音乐的魅力就在于它让任何文字的描述都显得苍白，一切都要交给耳朵和心灵。但谈及创作动因和历程，冯公让数次“情不自禁”地哽咽和激动，让我们看到了这部交响曲作者所要表达的对中国近代历史的反思，对近代高等教育的思索，对人性的或拷问、鞭挞或讴歌、赞美。</span></p>
<p>　　<span>交响曲的创作，让这位年轻的作曲家经常彻夜难眠，他的情绪、他的神经甚至他的身体，都因为这部交响乐每个音符的诞生而压抑、彷徨、亢奋、颤抖。</span></p>
<p>　　<span>这部交响乐共分四个乐章，创作历经</span><span>16</span><span>个月。冯公让坦诚，这</span><span>16</span><span>个月的创作过程对他来说，是一次次地洗礼自己的思想和精神。他读历史，看影像资料……很多时候，他的身体都在颤抖，不能自己，甚至情绪失控。</span></p>
<p>　　<span>“如果一定要给这四个乐章‘冠上’一个主题的话，那第一乐章就是献给为救国兴邦而上下求索的仁人志士的。”冯公让谈到，危机、战争、灾难，是第一乐章的基调，但他并不想让“战争”在乐曲中“具象化”，他相信了解中国近代史的人都能听懂他要表达的情感，理解他在恰逢甲午战争</span><span>120</span><span>周年时再通过史籍和影像回顾那段历史时精神的痛苦和挣扎，也能理解他在创作过程中因为无法摆脱战争阴影而带来的恐惧和痛苦。</span></p>
<p>　　<span>战争和黑暗让人恐惧，打破黑暗求索光明则需要极大的勇气和智慧。“天津大学前身北洋大学</span><span>1895</span><span>年建校，恰是中日甲午海战清廷战败后。它的诞生仿佛黑暗之中的一点光，明亮夺目，中国第一所现代大学的诞生是国人‘自强不息’精神写照，也是中国大学之精神。”冯公让坦诚，天津大学双甲子校庆让他产生了写一部交响乐的“献礼”的冲动，但他的作品却绝不局限于写天津大学，而是写百余年的中国近代史中人们对于国家和民族未来光明之求索。</span></p>
<p>　　<span>第一乐章之后，冯公让创作的是第四乐章。“尽管整部作品的构思已比较清晰，但事实上在具体创作每个乐章时，我都遇到了特别大的困难，甚至有时候觉得寸步难行。”冯公让说，写完第一章后他开始着手创作第四乐章，同时也在脑海中反复敲打第二和第三乐章。</span></p>
<p>　　<span>“第四乐章，我要写一种精神，一种‘自强不息’的精神。”冯公让说，这是他对于天津大学</span><span>120</span><span>年校史的理解，而给他创作灵感的则是</span><span>12</span><span>年前他从音乐学院毕业刚到天大工作时，看到青年湖上赛龙舟的震撼：“年轻人，光着膀子、敲着鼓、喊着号子，这样的场景正是一种合作精神、集体力量和自强不息精神的写照。”为了将这种“号子”表达出来，冯公让遍览各地龙舟号子，但最终却觉得任何一种“号子”都难以表达他想要的那种青春气息。最终，他借鉴了简约派的马达艺术，利用合唱和交响的配合，表达出了自己心中的这种青春昂扬的感受。在冯公让看来，“如果说第四乐章也是献礼的话，那就是献给继往开来者。”</span></p>
<p>　　<span>第三章的创作让冯公让又陷入了一种矛盾、冲突、斗争和阴冷的氛围里，因为他写的是文革的十年浩劫，“我没有经历过这场浩劫，但我的母亲每每提起，都会忍不住流泪。我也看了很多写这段历史的书籍和音像资料，我能感受到我的内心在颤抖。”于是第三章的开篇便是一支长笛阴冷而空旷地呜咽宛转，奠定了整个篇章“冷”的基调。“第三章，我希望通过音乐为坚持真理、追求真理的勇士们唱一唱葬歌。”</span></p>
<p>　　<span>《第一交响曲》的第二乐章描绘的则是新文化运动和五四运动中探索、求知的力量。“那种天不怕、地不怕的探索精神。”冯公让说，这是人们对于冲破黑暗、寻找光明的渴望，也正是这个国家和民族自强不息的探索。（本站记者刘晓艳）</span></p></div>';
            $data[]='<div class="Custom_UnionStyle">
<p align="center">中航科工集团33所智能机器人研究室主任张新华</p>
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150710324274294527.png" oldsrc="W020150710324274294527.png" _fcksavedurl="/webpic/W0201507/W020150710/W020150710324274294527.png"></p>
<p align="center">《人民日报》 2014年12月04日　 06 版</p>
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150710324274462763.jpg" oldsrc="W020150710324274462763.jpg" _fcksavedurl="/webpic/W0201507/W020150710/W020150710324274462763.jpg"></p>
<p>　　印刷机器人、切割机器人、装配机器人等各式各样的轻巧型工业机器人站成一排， “旋转、拨动、夹持、定位……”一气呵成，张新华得意地向大家展示他们为劳动密集型行业研制成功的系列化轻巧型机器人产品。</p>
<p>　　张新华是中国航天科工集团公司三院33所智能机器人研究室主任，同事们说，新华是一个地地道道的“机器人迷”，一旦研究起机器人，他常常忘记下班。值得一提的是，张新华带领团队研制成功的装卸源机器人，可以实现放射源无人化装卸操作，被誉为我国首台应用于油田测井前线的航天“特种兵”。</p>
<p>　　2002年3月，从天津大学机械设计及理论专业博士毕业的张新华应聘来到33所，初出茅庐就承担起了33所伺服系统的预研工作。扎实的理论功底和良好的专业技术让张新华很快脱颖而出。</p>
<p>　　有一次，所里将一个重大难题交给张新华，他困了就趴在桌上歇会儿，晚上就睡在实验室的凳子上，经过40多天奋战，终于攻克了技术难关。此后，张新华先后担任多个型号伺服系统主任设计师，取得一系列成果。</p>
<p>　　机遇偏爱有准备的头脑。2011年2月24日，伴随着国内外机器人研究的热潮，33所也成立了智能机器人研究室，38岁的张新华被任命为研究室主任。然而，机器人要搞起来很容易，但要在国内占有一席之地却并非易事。</p>
<p>　　“我们的首要任务就是尽快找到合适的切入点。”张新华敏锐地意识到，确定发展方向决不能靠拍脑袋，必须走出去。张新华带领自己的团队在全国进行了长达一年的深入调研。“我们的研究方向经历了一个由发散到收敛的过程，很多方向的确定都是走出来和比出来的。比如轻巧型工业机器人最早并不是我们的重点方向，但张主任带队调研后发现，这种可以把人员从重复性劳动中解放出来的机器人市场潜力巨大，后来我们就将其调整为重点方向了。”研制人员王晓林的一番话道出了“走出去”的重要性。</p>
<p>　　“我对机械还比较了解，但智能机器人研制是一项十分复杂的系统工程，必须进行大量学习和调研。”对于学习的重要性，张新华有着清醒的认识。</p>
<p>　　2013年，中国市场共销售工业机器人近3.7万台，成为全球第一大工业机器人消费市场。国产工业机器人也异军突起，预计今年国产工业机器人销售总量将超过1.2万台，同比增长25%左右。</p>
<p>　　面对发展如此快速的工业机器人市场，张新华兴奋地说：“我们要发扬航天精神，利用航天核心技术的独特优势，解决制约国内机器人发展的关键技术瓶颈，把我们的智能机器人产业做强做大，把我们智能机器人研究室打造成国内一流的研发团队。”</p>
<p>　　人民日报：<a href="http://paper.people.com.cn/rmrb/html/2014-12/04/nw.D110000renmrb_20141204_6-06.htm" _fcksavedurl="http://paper.people.com.cn/rmrb/html/2014-12/04/nw.D110000renmrb_20141204_6-06.htm">http://paper.people.com.cn/rmrb/html/2014-12/04/nw.D110000renmrb_20141204_6-06.htm</a></p></div>';
            $data[]='<div class="Custom_UnionStyle">
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150714374333008944.jpg" oldsrc="W020150714374333008944.jpg" _fcksavedurl="/webpic/W0201507/W020150714/W020150714374333008944.jpg"></p>
<p align="center">天大学生参观天津市规划展览馆</p>
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150714374333060320.jpg" oldsrc="W020150714374333060320.jpg" _fcksavedurl="/webpic/W0201507/W020150714/W020150714374333060320.jpg"></p>
<p align="center">天大学生参观海鸥手表厂</p>
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150714374333118932.jpg" oldsrc="W020150714374333118932.jpg" _fcksavedurl="/webpic/W0201507/W020150714/W020150714374333118932.jpg"></p>
<p align="center">天大学子参观天津国际生物医药联合研究院</p>
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150714374333164705.jpg" oldsrc="W020150714374333164705.jpg" _fcksavedurl="/webpic/W0201507/W020150714/W020150714374333164705.jpg"></p>
<p align="center">天大学生参观国家超级计算机天津中心</p>
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150714374333215113.jpg" oldsrc="W020150714374333215113.jpg" _fcksavedurl="/webpic/W0201507/W020150714/W020150714374333215113.jpg"></p>
<p align="center">天大学生参观建设中的于家堡高铁站</p>
<p align="center"><img style="BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-TOP-WIDTH: 0px" src="./W020150714374333269134.jpg" oldsrc="W020150714374333269134.jpg" _fcksavedurl="/webpic/W0201507/W020150714/W020150714374333269134.jpg"></p>
<p align="center">天大学生乘船参观海河综合治理改造工程</p>
<p>　　<span>本站讯（学生记者 </span><span>杨洪涛 </span><span>记者 </span><span>朱宝琳 </span><span>摄影 </span><span>赵珺鹏 </span><span>聂婷娟）</span><span>6</span><span>月</span><span>26</span><span>日，百余名天津大学优秀学子应天津市委代理书记、市长黄兴国的邀请，在市委、市政府相关部门的精心安排下，进行了为期一天的“天大学子津门行”活动。参观途中，学生们实地了解了天津的发展规划和突出成就，不时发出阵阵惊叹和掌声，他们被天津的历史文化之美、城市建设之美、未来前景之美所吸引、震撼，“民族自尊心和自信心一次次爆棚”。</span></p>
<p>　　<span>当日行程紧凑、充实，天大学子依次考察了天津市规划展览馆、中科院天津工业生物技术研究所、空客</span><span>A320</span><span>天津总装项目、海鸥手表厂、天津自贸试验区东疆港区服务大厅（途径东疆湾沙滩、邮轮母港、天津港太平洋国际集装箱码头）、天津国际生物医药联合研究院、国家超级计算机天津中心、于家堡高铁站、滨海新区中心商务区、海河教育园区中国（天津）职业技能公共实训中心、天津文化中心，并乘船参观海河综合治理改造工程。从展览场馆到研究院所，从企业公司到文化中心，天津的发展情况一览无遗。</span></p>
<p>　　<span>“来天津七八年了，每次看展览都有新变化，新惊喜。”来自管理与经济学部目前主修工商管理的宋瑶在参观完天津市规划展览馆后感慨。宋瑶在天津大学从本科一直读到博士，天津是她的第二故乡。父母以前很希望她回家乡辽宁工作，但是现在天津和辽宁之间通了高铁，两个小时就可以回家看看，因此父母也就不再要求女儿回家乡了。宋瑶学习研究的是区域经济发展规划，对于天津和自己的发展她很有信心：“我在学校参与了科技孵化器项目，得到了政策资金各方面的支持。将来工作了我希望做自己擅长并感兴趣的事情——把技术和经济结合起来。天津的科技型中小企业很多，这些‘小巨人’助力天津发展也给我们提供了大量的机会。这次</span><span>360</span><span>度全方位无死角的考察，特别是看到滨海新区的发展，更加坚定了我留在天津的决心，和天津一起成长。”</span></p>
<p>　　<span>天津国际邮轮母港的客运大厦的外形就像一艘大型邮轮，引起建工学院水利工程专业硕士生杨旭的巨大兴趣，他说：“我本科阶段主修港口方面的知识，以前参观的都是货港，这次来到邮轮港口，听人介绍</span><span>15</span><span>层高、内部构造精细的邮轮，特别震撼。”谈起天津的建设与自己的关系，他说：“天津的港口发展很快，虽然东疆、北疆已经建设好了，但是南疆正在建设中，有很多机会，我会优先考虑在天津发展。”</span></p>
<p>　　<span>在国家超级计算机天津中心，大家纷纷与在</span><span>2010</span><span>年运算速度世界排名第一的“天河一号”合影留念。超算中心为全国科研机构和央企提供高性能计算服务，来自管理与经济学部金融学的何枫就领略过它的魅力——“在天大有一个分中心提供计算接口，我们做市场模型试验，普通电脑运算很慢要一两天，但是超级计算机要快得多，节省时间可以更快将成果推广出去。”</span><span>何枫平时做过很多情景模拟以减少金融风险的试验，他希望发挥自己的专业特长优势，将来在天津高校或金融机构工作。</span></p>
<p>　　<span>于家堡高铁站将于今年</span><span>8</span><span>月投入试运营，届时，从北京南站到天津自贸区只需</span><span>45</span><span>分钟。于家堡站的椭圆形壳体像一个美丽的贝壳，而在它的设计建设过程中，天大师生也参与进来。建筑学院艺术设计专业的本科生钱丰就跟着导师为高铁站消防方面提供技术支持，“我们查阅了大量的资料进行分析设计，最大的收获是把学习和实践结合起来，而且对滨海新区的发展有了深入的认识。”此外，钱丰还参与了天津支援西藏的一个项目，到昌都小学建设科技活动室，把</span><span>3D</span><span>打印等科技带到边远山区，让那里的孩子也切身感受到创新的魅力。由于高原上作业困难，所以钱丰采用“模块化”设计活动室，在满足展示科技成果的同时力求简捷，他说“我们不仅要学习知识，更应该把它投入到社会服务中去。”</span></p>
<p>　　<span>在滨海新区中心商务区，学生了解到，商务区内布局了总部经济、金融创新、科技与新一代信息技术、跨境贸易电子商务、文化传媒创意等产业。滨海新区的发展也为大学生创业提供了许多机会和优惠政策，环境学院环境规划专业的研究生崔元彰就紧跟“大众创业、万众创新”“互联网</span><span>+</span><span>”的时代潮流，拥有了自己的创业项目，他表示，我们要勇敢地去实现自己的梦想。</span></p>
<p>　　<span>当晚，天津市委代理书记、市长黄兴国及相关市领导，天津大学党委书记刘建平、校长李家俊与学子们共进晚餐，亲切交谈。学生们表示，这一天不虚此行，对天津的发展充满信心，希望把天津作为自己的职业启航之地，实现自我价值。</span></p>
<p>　　<span>参与“天大学子津门行”活动的一百名学生是在众多报名者中筛选出来的，为了让广大学生了解本次活动，大家把考察情况和自己的感悟分享给天津大学官方微博、微信进行了“直播”，让更多的人了解天津、爱上天津，与天津一起成长。</span></p></div>';
            
            foreach ($rData as $key => $value) {
                var_dump($returnData);  
                $returnData = $fun->$funName($value['id'],$data[$key%5]);
                
            }
                break;

            case 'getArtic':
                $returnData = $fun->$funName();

                break;
            
            case 'getPicturesShow':
                $returnData = $fun->$funName(4);

                break;
                
            case 'getEducationList':
                $returnData = $fun->$funName(1);

                break;

            case 'getNewsPage':
                $returnData = $fun->$funName();

                break;
            default:
                # code...
                break;
        }

        return $returnData;
   }
   
}