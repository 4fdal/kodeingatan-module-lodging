import { HddOutlined, HomeOutlined, MinusOutlined } from '@ant-design/icons';
import React from 'react';

export default [
  {
    key: 'admin.lodging',
    label: 'Penginapan',
    title: 'Penginapan',
    icon: <HomeOutlined />,
    add_active_route: ['admin.master'],
    children: [
      {
        key: 'admin.master',
        label: 'Master',
        title: 'Master',
        icon: <HddOutlined />,
        add_active_route: ['admin.room_type.index'],
        children: [
          {
            icon: <MinusOutlined />,
            key: 'admin.room_type.index',
            permission: 'room_type.browse',
            label: 'Tipe Kamar',
            title: 'Tipe Kamar',
            as: 'admin.room_type.',
            add_active_route: [],
          },
          {
            icon: <MinusOutlined />,
            key: 'admin.room.index',
            permission: 'room.browse',
            label: 'Kamar',
            title: 'Kamar',
            as: 'admin.room.',
            add_active_route: [],
          },
          {
            icon: <MinusOutlined />,
            key: 'admin.additional_service.index',
            permission: 'additional_service.browse',
            label: 'Layanan',
            title: 'Layanan',
            as: 'admin.additional_service.',
            add_active_route: [],
          },
        ],
      },
    ],
  },
];
