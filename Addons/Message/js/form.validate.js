/*******************************************************************************
 * copyright: www.aweb.cc filename: form_validate.js revision: 2.0 createdate:
 * 2010-10-27 author: lovebslq
 * description：jQuery.validator BSLQ写的表单验证插件整个事件都在命名空间“BSLQ”里面，然后通过一个入口来调用（BSLQ.validator），这个入口将对每一个需要验证的元素验证一遍，然后再给它们绑定一个keyup事件；再之后每一次触发都会走之前的绑的所有函数；
 * 绑定的函数有:
 * BSLQ.required 验证不能为空
 * BSLQ.number 验证只能为正整数字
 * BSLQ.currency 货币类型
 * BSLQ.isIdCardNo 身份证号码
 * BSLQ.MilitaryNo 军人证
 * BSLQ.passportNo 护照
 * BSLQ.phone 电话号码（座机）
 * BSLQ.mobile 手机号码
 * BSLQ.allphone 联系方式（包括座机，手机等所有的）
 * BSLQ.phone_reg 传真号码
 * BSLQ.short_mobile 公司短号
 * BSLQ.zip 判断邮编
 * BSLQ.url 判断URL
 * BSLQ.change_value 判断是否改变
 * BSLQ.email 邮箱验证
 * BSLQ.unchinese 不能是中文
 * BSLQ.equalTo 修改密码必须一至
 * BSLQ.repassword
 * 重复上一次的密码
 ******************************************************************************/
var BSLQ = {};
BSLQ.empty = function(v) {
	var result = false;
	switch (typeof v) {
	case 'undefined':
		result = true;
		break;
	case 'string':
		var v = v.replace(/(^\s*)|(\s*$)/g, "");
		if (v.length == 0) {
			result = true;
		} else if (v == 'undefined') {
			result = true;
		}
		break;
	case 'boolean':
		if (!v) {
			result = true;
		}
		break;
	case 'number':
		if (0 === v) {
			result = true;
		}
		break;
	case 'object':
		if (null === v) {
			result = true;
		}
		break;
	default:
		result = false;
		break;
	}
	return result;
};

BSLQ.accomplish = '';
/**
 * BSLQ.validator 提交的时候调用验证入口； +---------------------------------
 *
 * @author lovebslq 2012-4-14 +---------------------------------
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param array
 *            formArray 验证的 class ，验证的函数；一个二维的键值对
 * @param string
 *            html5 判断是否是html5，默认为'YES'; +---------------------------------
 * @return void
 */
BSLQ.validator = function(validatorForm, formArray, html5) {
	var html5 = arguments[2] ? arguments[2] : 'YES';
	for (var i in formArray) {
		for (var j in formArray[i]) {
			if ('YES' == html5) {
				var this_dom = jQuery('.' + i + '[form="' + validatorForm + '"]');
			} else {
				var this_dom = jQuery('#' + validatorForm + ' .' + i);
			}
			BSLQ.addError(this_dom, i);
			BSLQ[j](this_dom, validatorForm, this_dom.val());
		}
		BSLQ.keyUp(this_dom, formArray[i]);
	}

};
/**
 * BSLQ.addError 初始化验证框（加上返回错识破信息） +---------------------------------
 *
 * @author lovebslq 2012-4-14 +---------------------------------
 * @param string
 *            element 当前验证的DOM
 * @param functionName
 *            incident 当前验证的方法；
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 *            +---------------------------------
 * @return void
 */
BSLQ.addError = function(thisDom, className) {
	if (!thisDom.next().hasClass('errorBox')) {
		thisDom.after('<div class="errorBox"><span class="error"></span></div>');
	};
};
/**
 * BSLQ.validator 键盘弹起的时候调用验证函数 +---------------------------------
 *
 * @author lovebslq 2012-4-14 +---------------------------------
 * @param string
 *            element 当前验证的DOM
 * @param functionName
 *            incident 当前验证的方法；
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 *            +---------------------------------
 * @return void
 */
BSLQ.keyUp = function(element, incident, validatorForm) {
	element.off('keyup').on('keyup', function() {
		for (var k in incident) {
			BSLQ[k](element, validatorForm, element.val());
		}
	});
};
/**
 * BSLQ.cb 验证的回调函数 +---------------------------------
 *
 * @author lovebslq 2012-4-14 +---------------------------------
 * @param string
 *            element 当前验证的DOM
 * @Param string
 *            validatorName 验证的函数名称
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            prompt 验证出错误的提示语句默认为空； +---------------------------------
 * @return void
 */
BSLQ.cb = function(element, validatorName, validatorForm, prompt) {
	var validatorName = arguments[1] ? arguments[1] : '';
	var prompt = arguments[3] ? arguments[3] : '';
	var $this_error = element.next('.errorBox');
	var $this_errortext = element.next('.errorBox').find('.error');
	if ($this_error.hasClass('vError')) {
		if (BSLQ.empty(prompt)) {
			if ($this_error.hasClass(validatorName)) {
				$this_error.removeClass('vError');
				$this_errortext.empty();
				if (jQuery('.vError').size() == 0) {
					BSLQ.accomplish = 'YES';
					return
				}
				BSLQ.accomplish = '';
			}
		} else {
			if (!($this_error.hasClass(validatorName))) {
				$this_errortext.text(prompt)
				$this_error.removeClass().addClass('errorBox vError ' + validatorName);
				BSLQ.accomplish = '';
				return;
			}
		}
	} else {
		if (!BSLQ.empty(prompt)) {
			$this_error.addClass('vError ' + validatorName);
			$this_errortext.text(prompt);
			BSLQ.accomplish = $this_error;
			return;
		}
		if (jQuery('.vError').size() == 0) {
			BSLQ.accomplish = 'YES';
		}
	}
};

/**
 * 验证不能为空 +---------------------------------
 *
 * @author lovebslq 2012-4-14 +---------------------------------
 * @param string
 *            element 当前的验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.required = function(element, validatorForm, value) {
	if (!BSLQ.empty(value)) {
		BSLQ.cb(element, 'required', validatorForm);
	} else {
		BSLQ.cb(element, 'required', validatorForm, '不能为空');
	}
};
/**
 * 验证只能为正整数字 +---------------------------------
 *
 * @author lovebslq 2012-6-11 +---------------------------------
 * @param string
 *            void +---------------------------------
 * @return void
 */
BSLQ.number = function(element, validatorForm, value) {
	var NO_reg = /^\d+$/;
	if (NO_reg.test(value) || '' == value) {
		BSLQ.cb(element, 'number', validatorForm);
	} else {
		BSLQ.cb(element, 'number', validatorForm, '只能为数字');
	}
};
/**
 * 验证只能为货币类型 +---------------------------------
 *
 * @author lovebslq 2012-6-11 +---------------------------------
 * @param string
 *            void +---------------------------------
 * @return void
 */
BSLQ.currency = function(element, validatorForm, value) {
	var NO_reg = /^\d+(\.\d+)?$/;
	if (NO_reg.test(value) || '' == value) {
		BSLQ.cb(element, 'currency', validatorForm);
	} else {
		BSLQ.cb(element, 'currency', validatorForm, '只能为货币类型');
	}
};
/**
 * 身份证号码验证 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.isIdCardNo = function(element, validatorForm, value) {
	var idcard_reg = /^\d{14}(\d{4}|(\d{3}[xX])|\d{1})$/;
	if (idcard_reg.test(value) || '' == value) {
		BSLQ.cb(element, 'isIdCardNo', validatorForm);
	} else {
		BSLQ.cb(element, 'isIdCardNo', validatorForm, '请输入正确的身份证号码');
	}
};
/**
 * 军人证号码验证 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.MilitaryNo = function(element, validatorForm, value) {
	var idcard_reg = /^\d{14}(\d{4}|(\d{3}[xX])|\d{1})$/;
	if (idcard_reg.test(value) || '' == value) {
		BSLQ.cb(element, 'isIdCardNo', validatorForm);
	} else {
		BSLQ.cb(element, 'isIdCardNo', validatorForm, '请输入正确的身份证号码');
	}
};
/**
 * 护照号码验证 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.passportNo = function(element, validatorForm, value) {
	var idcard_reg = /^\d{14}(\d{4}|(\d{3}[xX])|\d{1})$/;
	if (idcard_reg.test(value) || '' == value) {
		BSLQ.cb(element, 'isIdCardNo', validatorForm);
	} else {
		BSLQ.cb(element, 'isIdCardNo', validatorForm, '请输入正确的身份证号码');
	}
};
/**
 * 除手机之外的电话号码验证 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.phone = function(element, validatorForm, value) {
	var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
	if (tel.test(value) || '' == value) {
		BSLQ.cb(element, 'phone', validatorForm);
	} else {
		BSLQ.cb(element, 'phone', validatorForm, '请输入正确的电话号码');
	}
};
/**
 * 手机号码验证 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.mobile = function(element, validatorForm, value) {
	var length = value.length;
	var mobile = /^1[0-9]{2}\d{8}$/;
	if ((length == 11 && mobile.test(value)) || '' == value) {
		BSLQ.cb(element, 'mobile', validatorForm);
	} else {
		BSLQ.cb(element, 'mobile', validatorForm, '请输入正确的手机号');
	}
};
/**
 * 所有的电话号码验证 +---------------------------------
 *
 * @author lovebslq 2012-4-18 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.allphone = function(element, validatorForm, value) {
	var length = value.length;
	var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
	var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
	if ((length == 11 && mobile.test(value)) || ('' == value) || (tel.test(value))) {
		BSLQ.cb(element, 'allphone', validatorForm);
	} else {
		BSLQ.cb(element, 'allphone', validatorForm, '请输入正确的联系方式');
	}
};
/**
 * 传真号码验证 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.phone_reg = function(element, validatorForm, value) {
	var phone_reg = /^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{1,6}))?$/;
	if (phone_reg.test(value) || '' == value) {
		BSLQ.cb(element, 'phone_reg', validatorForm);
	} else {
		BSLQ.cb(element, 'phone_reg', validatorForm, '请输入正确的传真号');
	}
};
/**
 * 公司短号 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.short_mobile = function(element, validatorForm, value) {
	phone_reg = /^[0-9]{2,6}$/;
	if (phone_reg.test(value) || '' == value) {
		BSLQ.cb(element, 'short_mobile', validatorForm);
	} else {
		BSLQ.cb(element, 'short_mobile', validatorForm, '请输入正确的公司短号');
	}
};
/**
 * 邮编的验证 +---------------------------------
 *
 * @author lovebslq 2012-4-13 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.zip = function(element, validatorForm, value) {
	var zip_reg = /^[1-9]\d{5}$/;
	if (zip_reg.test(value) || ('' == value)) {
		BSLQ.cb(element, 'zip', validatorForm);
	} else {
		BSLQ.cb(element, 'zip', validatorForm, '请输入正确的邮编');
	}
};
/**
 * URL地址验证 +---------------------------------
 *
 * @author Nzing
 * @access public
 * @version 1.0 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.url = function(element, validatorForm, value) {
	var url_reg = /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;
	if (url_reg.test(value) || ('' == value)) {
		BSLQ.cb(element, 'url', validatorForm);
	} else {
		BSLQ.cb(element, 'url', validatorForm, '请输入正确的URL地址');
	}
};
/**
 * 判断是否改变； +---------------------------------
 *
 * @author lovebslq 2012-4-11 里面涉及到一个old_value 它需要验证元素包含一个"old_value"来装原始数据；
 *         +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.change_value = function(element, validatorForm, value) {
	var this_old_value = element.attr('old_value');
	if (!BSLQ.empty(this_old_value)) {
		if (value != this_old_value) {
			BSLQ.cb(element, 'change_value', validatorForm);
		} else {
			BSLQ.cb(element, 'change_value', validatorForm, '你还没做任何修改');
		}
	}
};
/**
 * 邮箱的验证 +---------------------------------
 *
 * @author lovebslq 2012-4-16 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.email = function(element, validatorForm, value) {
	var email_reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if (email_reg.test(value) || ('' == value)) {
		BSLQ.cb(element, 'email', validatorForm);
	} else {
		BSLQ.cb(element, 'email', validatorForm, '请输入正确的邮箱');
	}
};
/**
 * 验证不能是中文 +---------------------------------
 *
 * @author lovebslq 2012-4-16 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.unchinese = function(element, validatorForm, value) {
	var chinese_reg = /[\u4e00-\u9fa5]/g;
	if (chinese_reg.test(value)) {
		BSLQ.cb(element, 'unchinese', validatorForm, '请输入正确的银行卡号');
	} else {
		BSLQ.cb(element, 'unchinese', validatorForm);
	}
};
/**
 * 验证重复密码 +---------------------------------
 *
 * @author lovebslq 2012-4-16 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.equalTo = function(element, validatorForm, value) {
	var old_passowd = jQuery('#' + element.attr('old_id')).val();
	if (value == old_passowd) {
		BSLQ.cb(element, 'equalTo', validatorForm);
	} else {
		BSLQ.cb(element, 'equalTo', validatorForm, '两次密码不一至');
	}
};
/**
 * 验证重复密码 +---------------------------------
 *
 * @author lovebslq 2012-4-16 +---------------------------------
 * @param string
 *            element 验证的DOM
 * @param string
 *            validatorForm 验证的表单ID号（'formIdName'）;
 * @param string
 *            value 当前验证的值 +---------------------------------
 * @return void
 */
BSLQ.repassword = function(element, validatorForm, value) {
	var old_passowd = jQuery('#passwordone').val();
	if (value == old_passowd) {
		BSLQ.cb(element, 'equalTo', validatorForm);
	} else {
		BSLQ.cb(element, 'equalTo', validatorForm, '两次密码不一至');
	}
};
