<?php

  Class Extension_UserAgentFeatureDetection extends Extension {

    public function about() {
      return array(
        'author'       => array(
          'email'    => 'brian@briandrum.net',
          'name'     => 'Brian Drum',
          'website'  => 'http://briandrum.net'
        ),
        'description'  => 'The User Agent Feature Detection extension makes information about user agent features available in the param pool for the purposes of responsive web design.',
        'name'         => 'User Agent Feature Detection',
        'release-date' => '2011-11-28',
        'version'      => '0.1'
      );
    }

    public function install() {
      Symphony::Configuration()->set('maxwidth', 480, 'feature');
      Administration::instance()->saveConfig();
    }

    public function uninstall() {
      Symphony::Configuration()->remove('feature');
      Administration::instance()->saveConfig();
    }

    public function getSubscribedDelegates(){
      return array(
        array(
          'page'     => '/system/preferences/',
          'delegate' => 'AddCustomPreferenceFieldsets',
          'callback' => 'appendPreferences'
        ),
        array(
          'page'     => '/system/preferences/',
          'delegate' => 'Save',
          'callback' => 'savePreferences'
        ),
        array(
          'page'     => '/frontend/',
          'delegate' => 'FrontendParamsResolve',
          'callback' => 'addParam'
        )
      );
    }

    public function appendPreferences($context) {
      $fieldset = new XMLElement('fieldset');
      $fieldset->setAttribute('class', 'settings');
      $fieldset->appendChild(new XMLElement('legend', __('User Agent Feature Detection')));

      $current = Symphony::Configuration()->get('maxwidth', 'feature');
      $input = Widget::Input('settings[feature][maxwidth]', $current, 'number',
        array(
          'min'   => 0,
          'step'  => 10
        ));
      $label = Widget::Label('Default Maximum Width', $input);
      $fieldset->appendChild($label);

      $fieldset->appendChild(new XMLElement('p', __('For user agents without JavaScript or those with JavaScript that do not accept cookies.'), array('class' => 'help')));

      $context['wrapper']->appendChild($fieldset);
    }

    public function addParam($context) {

      // detection cookie
      $feature_detection  = !empty($_COOKIE['feature_detection']) ? $_COOKIE['feature_detection'] : 0;
      $context['params']['feature-detection'] = $feature_detection;

      // maxwidth cookie
      $feature_maxwidth_fallback = 480;
      $feature_maxwidth = !empty($_COOKIE['feature_maxwidth']) ? $_COOKIE['feature_maxwidth'] : $fallback;
      $context['params']['feature-maxwidth'] = $feature_maxwidth;

    }

  }

?>
