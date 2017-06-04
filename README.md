# 基于Laravel5的WEB系统分布式架构解决方案

一般的大型WEB 系统都是由大量的子系统、模块采用构件的方式进行搭建完成；整个系统必须要能解决大量用户并发访问、高并发请求、业务数据缓冲等一系列的关键功能；在PHP以前该类系统都是基于J2EE的底层技术开发设计的，对于目前已经很流行的MVC开发框架方面PHP更是很少有比较成功的产品以及经验可以供借鉴。

本文主要以实现类似于J2EE目前流行的MVC框架为目的，设计一个基于PHP的大型WEB系统分布式平台架构，并以一个实际例子（模拟FACEBOOK业务）详细说明分布式业务对象缓存、分布式文件系统存取、数据库集群、网页静态化处理、用户安全认证等技术的设计和使用。


## 1. 软件架构
### 1.1 组件或功能的划分
整个系统由各个独立的模块组建而成。
### 1.2	软件层次的划分或开发模式的考虑

## 2. 系统拓扑结构
### 2.1	系统物理拓扑结构

## 3. 应用设计结构
### 3.1	Laravel目录
### 3.2	基于“仓库模式”的业务逻辑和数据访问分离
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

以**UserInfoRepository**为例，该类实现了父类AbstractRepository的抽象方法model():

    function model()
    {
    	// 返回user_info这张表对应的Model（with namespace）
        return 'App\Models\UserInfoModel';
    }

请记住：通过继承AbstractRepository并实现抽象方法model()，便可利用面向对象语言的多态特性的把具体的数据对象和仓库关联起来，从而实现了代码复用。

#### 3.2.3 Model满怀喜悦地挥手告别Controller

在上一小节中，介绍了Repsoitory的逻辑结构，并使用UML类图展示了Reposiotry的具体架构。现在介绍逻辑结构图中的Data Source和Business Logic（业务逻辑），细心的读者已经注意到了业务逻辑下面带有下划线的XXXApi，它表示我们把业务逻辑不直接提供给Controller层，而是封装成Api，降低与Controller的耦合，方便复用，模块化开发，亦可遵循此约定来**分层独立**开发！

下面我从一个特化的例子来阐述**XXXModel + XXXRepository => XXXApi => XXXControler<---> Route**是如何工作的。

顾名思义，Data Source（数据源）是存放数据的仓库，及数据库，这里我们选择Mysql作为数据库。以数据库HWDeviceCloutRood中的user_info这张表为例：首先建立该表对应的Model，即UserInfoModel。UML类图如下：

![Model](http://i.imgur.com/4KLrorx.png)

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

![Api](http://i.imgur.com/AamkHAg.png)

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

![Final](http://i.imgur.com/FxmYTfh.png)