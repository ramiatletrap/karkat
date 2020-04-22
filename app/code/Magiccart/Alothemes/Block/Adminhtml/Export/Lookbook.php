<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2018-11-12 14:49:59
 * @@Function:
 */

namespace Magiccart\Alothemes\Block\Adminhtml\Export;

use Magento\Theme\Model\Theme\Collection;
use Magento\Framework\App\Area;

class Lookbook extends \Magiccart\Lookbook\Block\Adminhtml\Lookbook\Grid
{

    protected function _prepareCollection()
    {
        $collection = $this->_lookbookCollectionFactory->create();
        $this->setCollection($collection);
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        // $this->removeColumn('status');
        $this->removeColumn('edit');
        $this->_exportTypes = [];
        // $this->addExportType('*/*/menu', __('XML'));
    }

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('lookbook_id');
		$this->getMassactionBlock()->setFormFieldName('exportIds');

        $themesCollections = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Theme\Model\Theme\Collection');
		$themesCollections->addConstraint(Collection::CONSTRAINT_AREA, Area::AREA_FRONTEND);
		$themes = [];
		foreach ($themesCollections as $key => $value) {
			$themes[$value->getData('theme_path')] = $value->getData('theme_title');
		}
		$this->getMassactionBlock()->addItem('export', array(
			'label'    => __('Export'),
			'url'      => $this->getUrl('*/*/lookbook'),
			'additional' => array(
				'visibility' => array(
					'name' => 'theme_path',
					'type' => 'select',
					'class' => 'required-entry',
					'label' => __('Theme'),
					'values' => $themes //$stores
				)
			),
			'confirm'  => __('Are you sure?')
		));
		return $this;
	}

}
