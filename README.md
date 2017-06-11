# 基于Laravel5的WEB系统分布式架构解决方案

一般的大型WEB 系统都是由大量的子系统、模块采用构件的方式进行搭建完成；整个系统必须要能解决大量用户并发访问、高并发请求、业务数据缓冲等一系列的关键功能。

本文主要以实现前后端完全分离、低耦合、易扩展及高复用性的WEB应用为目的，设计一个基于Laravel框架的PHP大型WEB系统分布式平台架构，并以一个实际例子（配电室运维后台管理系统）详细说明分布式业务对象缓存、分布式数据库数据存取、数据库集群、网页静态化处理、用户安全认证等技术的设计和使用。


## 1. 软件架构
### 1.1 组件或功能的划分
整个系统由各个独立的模块组建而成。
### 1.2	软件层次的划分或开发模式的考虑

- 表示层：表示层采用Vue.js、Bootstrap等来表现；
- 业务逻辑层：所有的业务逻辑部分由Laravel框架来处理，编写了Api以简化业务逻辑；
- 数据实体层：采用分布式数据库设计架构。

### 1.3	框架的建立

- 采用目前最流行的Laravel作为底层框架，基于MVC思想的开发模式构建整个系统，保证了整个应用系统结构的清晰，提高了易维护性；
- 整个系统采用模块化思想进行组件搭建，每个模块包含与其业务相关的所有数据文件、视图文件、业务逻辑处理是完全独立于其它模块的；
- 使用了缓存技术，提高了静态、动态页面的渲染速度；
- 对使用频繁的网页自动或定时实行网页静态化处理，静态的html网页使性能得到了极大提升；
- 从web服务器分离出静态的网页、图片、文件等，使用专用的分布式文件系统进行存储，通过URL的重写机制采用轻量级的http协议访问静态资源；一方面分担主服务器的压力，同时基于MogileFS的分布式系统对于数据的并发访问和数据灾难恢复提供性能和安全保障；
- 使用memcached分布式技术对业务数据进行缓存，减轻了对数据库的频繁操作。


### 1.4	组件化的考虑

业务组件： 

- \_example\_template\_XXXModel组件——和业务相对应的数据模型；
- \_example\_template\_XXXRepository组件——封装主要的数据库处理逻辑，使具体的数据库处理独立于业务处理；
- \_example\_template\_XXXApi组件——封装主要的业务处理逻辑。该组件基于模块创建，可复用；
- XXXController组件——职责单一，为Route提供路由接口，响应前端请求。


通用组件： 

- ApiInstanceFactory组件——用于创建Api实例，使用类似于Cocos2d-x风格的CREATE_FUNC方法；
- DBConfigUtil组件——用于动态连接数据库；
- DBDirector组件——用于为DB门面动态连接数据库。

### 1.5	安全的考虑

- 对涉及的保密数据，采用加密手法进行信息的传输；
- 对于异常处理，采用日志记录进行跟踪管理；
- MD5二次加密；
- Sql防注入；
- CRSF攻击。

## 2. 系统拓扑结构
### 2.1	系统物理拓扑结构

![](http://i.imgur.com/SDjOXPF.png)

### 2.2	系统逻辑拓扑结构

![LogicPic](http://i.imgur.com/OQPcDcC.png)

## 3. 应用设计结构
### 3.1	Laravel应用核心程序包结构

#### 3.1.1 app目录概览

![APP](http://i.imgur.com/RqZ7Lp1.png)

#### 3.1.2 核心文件一瞥

![Model](http://i.imgur.com/x5YSZvY.png)

![Repository](http://i.imgur.com/p0k8xIt.png)

![Api](http://i.imgur.com/iHGgxOz.png)


请注意：在扩展时，请尽量让派生类继承契约文件夹下的契约父类，以降低维护的成本。


#### 3.1.3 数据库配置

Laravel中数据库配置文件为config/database.php，打开该文件，设置内容如下：

    <?php
	return [
	    //默认返回结果集为PHP对象实例
	    'fetch' => PDO::FETCH_CLASS,
	    //默认数据库连接为mysql，可以在.env文件中修改DB_CONNECTION的值
	    'default' => env('DB_CONNECTION', 'mysql'),
	
	    'connections' => [
	        ...
	        // 数据库hw***root
	        'mysql' => [
	            'driver' => 'mysql',
	            'host' => env('DB_HOST', 'localhost'),
	            'database' => env('DB_DATABASE', 'forge'),
	            'username' => env('DB_USERNAME', 'forge'),
	            'password' => env('DB_PASSWORD', ''),
	            'charset' => 'utf8',
	            'collation' => 'utf8_unicode_ci',
	            'prefix' => '',
	            'strict' => false,
	        ],
 			// 数据库hw***node
	        'mysql_cloud_node' => [
	            'driver'    => 'mysql',
	            'host'      => env('DB_HOST', 'localhost'),
	            'database'  => env('DB_DATABASE_CLOUD_NODE', 'forge'),
	            'username'  => env('DB_USERNAME', 'forge'),
	            'password'  => env('DB_PASSWORD', ''),
	            'charset'   => 'utf8',
	            'collation' => 'utf8_unicode_ci',
	            'prefix'    => '',
	            'strict'    => false,
	            'engine'    => null,
	        ],
	        /** mysql_client表示客户的物业数据库信息---这里的host、databse、username和password在runtime动态赋值以实现复用 */
	        'mysql_client' => [
	            'driver'    => 'mysql',
	            'host'      => '',
	            'database'  => '',
	            'username'  => '',
	            'password'  => '',
	            'charset'   => 'utf8',
	            'collation' => 'utf8_unicode_ci',
	            'prefix'    => '',
	            'strict'    => false,
	            'engine'    => null,
	        ],
	      	...
	    ],		
		...
	];

修改数据库配置信息，该应用采用了两种方案：

1. 本地数据库连接——去修改.env对应值即可，然后在config/database.php/connections数组中添加。多个数据库配置，参考[这里](http://fideloper.com/laravel-multiple-database-connections "Multiple DB Connections in Laravel")。
2. 需要在运行期动态连接的数据库——仅需要在connections数组中添加mysql_client；即可使用Config::set()方法动态连接任何服务器上的数据库。

### 3.2	基于“仓库模式”的业务逻辑和数据访问分离

本章主要介绍后端开发过程中的一些重要特性，由于该应用的前后端完全分离——基于“前端请求·后端响应”的机制，前端负责MVC架构的View模块，所以这里主要介绍模型（Model）和控制器（Controller）模块。

在Laravel框架下，比较一般的开发流程是：

1. 使用DB门面、查询构建器或Eloquent ORM的Model来访问数据库；
2. 在Controller层中注入Model数据模型，然后访问数据库；
3. 在Route中编写Controller的Api，交递给前端。

存在的缺点：

- Model和Controller职责不单一，不利于维护和扩展；
- Controller主要负责和Route做交互，过多的逻辑写在Controller中，不利于复用；
- Model和Controller混合在一起，虽然可以实现功能，但会写更多重复代码，代码耦合性更强。

#### 3.2.1 仓库模式逻辑结构

首先需要声明的是设计模式和使用的框架以及语言是无关的，关键是要理解设计模式背后的原则。

从概念上讲，仓库模式（Repository Parttern）是把一个数据存储区的数据给封装成对象的集合并提供了对这些集合的操作。

Repository 模式将业务逻辑和数据访问分离开，两者之间通过 Repository 接口进行通信，通俗点说，可以把 Repository 看做仓库管理员，我们要从仓库取东西（业务逻辑），只需要找管理员要就是了（Repository），不需要自己去找（数据访问），逻辑结构如下图所示：

![Repository](http://i.imgur.com/uGmoeFq.png)

这种将数据访问从业务逻辑中分离出来的模式有很多好处：

- 集中数据访问逻辑使代码易于维护
- 业务和数据访问逻辑完全分离
- 减少重复代码
- 使程序出错的几率降低

#### 3.2.2 Repository最佳实践

要实现 Repository 模式，首先需要定义接口，这些接口就像 Laravel中的契约一样（面向对象编程都具备的习惯：面向接口编程），需要具体类去实现。假定有两个数据对象 UserInfo和NodeInfo。这两个数据对象上可以进行哪些操作呢？一般情况下，我们会做这些事情：

- 判断某记录或主键是否存在
- 获取所有记录
- 通过主键获取指定记录
- 创建一条新的记录
- 更新一条原有记录
- 通过属性字段获取相应记录
- 删除一条记录，等等

现在应该已经意识到如果我们为每个数据对象实现这些操作要编写多少重复代码，且此时Model和Controller是紧密耦合在一起的，不利于新功能的扩展和复用！当然，对小型项目而言，这不是什么大问题，但如果对大型应用而言，这显然是个坏主意。

现在，如果我们要定义这些操作，需要创建一个Repository接口IRepsoitory，然后子类AbstractRepsitory实现相应的接口。此时，仓库管理员已经具备了访问数据库的能力。但是，怎样让具体的数据对象（数据模型）和仓库关联起来呢？先看看UML类图吧：

![Repository](http://i.imgur.com/CdDcd3S.png)

其中，\_example\_template\_XXXRepository是**通用Repository模板**；**扩展**时只需自动生成相应的仓库类，然后简单配置即可。

以**UserInfoRepository**为例，该类实现了父类AbstractRepository的抽象方法model():

    function model()
    {
    	// 返回user_info这张表对应的Model（with namespace）
        return 'App\Models\UserInfoModel';
    }

请记住：AbstractRepository是契约父类，尽量让具体仓库派生类继承自契约父类，以降低维护成本。通过继承AbstractRepository并实现抽象方法model()，便可利用面向对象语言的多态特性的把具体的数据对象和仓库关联起来，从而实现了代码复用。


#### 3.2.3 Model满怀喜悦地挥手告别Controller

在上一小节中，介绍了Repsoitory的逻辑结构，并使用UML类图展示了Reposiotry的具体架构。现在介绍逻辑结构图中的Data Source和Business Logic（业务逻辑），细心的读者已经注意到了业务逻辑下面带有下划线的XXXApi，它表示我们把业务逻辑不直接提供给Controller层，而是封装成Api，降低与Controller的耦合，方便复用，模块化开发，亦可遵循此约定来**分层独立**开发！

下面我从一个特化的例子来阐述**XXXModel + XXXRepository => XXXApi => XXXControler<---> Route**是如何工作的。

顾名思义，Data Source（数据源）是存放数据的仓库，及数据库，这里我们选择Mysql作为数据库。以数据库hw***root中的user_info这张表为例：首先建立该表对应的Model，即UserInfoModel。UML类图如下：

![Models](http://i.imgur.com/TRR01Yp.png)

其中，\_example\_template\_XXXModel和\_example\_template\_client\_XXXModel分别为**通用Model模板**和**具体物业的Model模板**。**扩展**时只需选择对应模板自动生成相应的模型类，然后简单配置即可。

XXXModel常用的成员变量有：

    /**
     * @var string. The connection name for the model.
     * @NOTE You can change the connect by changing the value of $connection.
     */
    protected $connection = 'mysql';
    
    /** @var string. The table associated with the model. */
    protected $table = 'example_table_name';
    
    /** @var bool. Indicates if the model should be timestamped. */
    public $timestamps = false;
    
    /**
     * @var array. The attributes that aren't mass assignable.
     * @NOTE 如果想使用Mass Assignable，那么需要"显式"设置$fillable，或$guarded置为空数组（全部字段均可批量赋值）
     * 且二者只可设置其一，切记！它们决定create()是否可用！
     */
    protected $guarded = [];

通过设置相应的数据成员便可绑定到数据库中的一张表，它不像使用ASP.NET开发网站一样，一个数据Model需要程序员手动定义表中的字段对应的数据成员；特别地，Laravel框架的Eloquent ORM（对象关系映射）为我们封装了这些手动的操作，只需要简单配置，这是Laravel优雅的一个方面。但请注意：为了更好的提高开发效率，需要充分熟悉框架后，才可以优雅的方式进行开发。

到目前为止，有了UserInfoRepository（仓库管理员类）和UserInfoModel（数据模型类），那么是时候谈谈业务逻辑了，将在下一小节中详细介绍。

#### 3.2.4 Api的前世今生

之前已经介绍过，为解除业务逻辑和Controller的耦合，可以把仓库管理员与Controller分离。否则，仓库管理员访问数据库（其实就是业务逻辑）和Controller混在一起，这时如果别的控制器A需要使用当前控制器（依赖它）时，就不能为控制器A提供清晰的服务，这是因为一个规则：Controller的主要任务是响应请求（get、post等），且Controller中的每个方法对应一个路由（Route）；破坏了这一规则，就破坏了**单一职责原则**，程序的结构将越来越复杂混乱。

为了让程序具有易扩展性、高复用性及低耦合性，设计了Api，最终的Api提供了十分清晰的接口。下面介绍我在开发Api时使用的特色技术。依然从UML类图入手：

![API](http://i.imgur.com/MxcVTeI.png)


其中：

1. \_example\_template\_XXXApi是**通用Api模板**；**扩展**时只需自动生成相应的Api类，然后简单配置即可；
2. create方法的参数$runtimeDatabaseName具有默认值""，如不需要在运行期指定数据库，那么使用默认值即可。

请记住：父类Api是我规定的一个契约，所有的Api子类都应该继承它。Api仅有一个数据成员$repositoryMgr（仓库管理员），那么如何关联到具体数据模型的仓库管理员呢？这里我借鉴了Cocos2d-x中[CREATE_FUNC](http://baike.baidu.com/link?url=6WfTtr1SaeezotqiTea9e43X8xDAPaIaLPB2CrZMpg6G_8UC157gsjPTJ3F5mgisHAwajSunz17-jbandHJKbLtFjIdxpfMY9wC0B3unAaG "Cocos2d-x CREATE_FUNC")宏的设计，并加以改进为ApiInstanceFactory工具类，该工具类使用**静态工厂方法模式**；只需要在派生类Api中的静态方法create中调用该工具类的CREATE_FUNC即可关联到具体的仓库管理员。


#### 3.2.5 Outstanding Feature

这里总结一下后端项目的突出特性：

- 基于Repository的业务逻辑和数据访问分离，使得应用具有易扩展性和高复用性
- 仅需简单配置即可新增**具体的仓库**及**具体的Api**，具有极高复用性
- Model和Controller解耦，提供Api与之交互
- 提供了Api，并借助**静态工厂模式**实现了Cocos2d-x style **CREATE_FUNC**，快速创建Api
- 每个模块职责单一，方便分层独立开发
- 一个没有被关注的特性：借助PhpStorm IDE自动生成特化的Model、Api及Repository


基于以上全部特性，自动生成如下三种模板，提高开发效率并降低错误：

1. \_example\_template_XXXModel.php
2. \_example\_template_XXXRepository.php
3. \_example\_template_XXXApi.php

因此，系统核心架构如下图所示：

![Final](http://i.imgur.com/ERM9Hnm.png)

### 3.3	基于“订阅·发布”模式的消息驱动模型

数据或显示的同步可采用“观察者模式”，即“订阅·发布模式”。Laravel框架下的开发不需要自己实现该模式，可采用框架提供的**事件和监听器**，相关类分别写在项目的app/Events目录和app/Listeners，并需要在Providers/EventServiceProvider.php里面注册。

在该应用中，将数据库表间同步更新操作采用事件驱动，在Api中需要同步表数据的地方触发事件（Event），然后在相应的监听器类（Listener）里进行相应更新即可。比如，物业信息改变的事件及其监听器的UML类图如下：

![EventListener](http://i.imgur.com/gwnhjzx.png)

其中，Event是作为契约的父类，我们应该让事件子类继承自它。事件子类继承了父类中的公有成员变量：$MSG_TYPE及$data，它们分别是**消息的类型**和事件触发时**传递的数据**。在事件触发的地方传递消息类型和数据，在Listener中的handle方法中进行逻辑处理。

其他消息驱动模型类似于此。