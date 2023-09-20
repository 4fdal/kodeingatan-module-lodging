import {
  HddOutlined,
  HomeOutlined,
  MinusOutlined,
  RightOutlined,
} from '@ant-design/icons';
import React from 'react';

export default [
  {
    key: 'admin.lodging',
    as: 'admin.lodging.',
    label: 'Penginapan',
    title: 'Penginapan',
    icon: <HomeOutlined />,
    add_active_route: ['admin.master', 'admin.lodging.room.index'],
    children: [
      {
        key: 'admin.master',
        as: 'admin.master.',
        label: 'Master',
        title: 'Master',
        icon: <HddOutlined />,
        add_active_route: ['admin.lodging.room.index'],
        children: [
          {
            icon: <MinusOutlined />,
            key: 'admin.lodging.room_type.index',
            permission: 'room_type.browse',
            label: 'Tipe Kamar',
            title: 'Tipe Kamar',
            as: 'admin.lodging.room_type.',
            add_active_route: [],
          },
          // {
          //   icon: <MinusOutlined />,
          //   key: 'admin.lodging.room.index',
          //   permission: 'room.browse',
          //   label: 'Kamar',
          //   title: 'Kamar',
          //   as: 'admin.lodging.room.',
          //   add_active_route: [],
          // },
        ],
      },
    ],
  },
];
