import { MinusOutlined, RightOutlined } from '@ant-design/icons'
import React from 'react'


export default [
    {
        key: 'admin.lodging',
        as: 'admin.lodging.',
        label: 'Lodging',
        title: 'Lodging',
        icon: <RightOutlined />,
        add_active_route: [
            'admin.lodging.template.index',
        ],
        children: [
            {
                icon: <MinusOutlined />,
                key: 'admin.lodging.template.index',
                permission: 'lodging.template.browse',
                label: 'Template',
                title: 'Template',
                as: 'admin.lodging.template.',
                add_active_route: [],
            },
        ],
    },
]

