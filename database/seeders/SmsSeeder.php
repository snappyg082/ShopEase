<?php

namespace Database\Seeders;

use App\Models\Sms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsSeeder extends Seeder
{
    public function run()
    {
        Sms::create([
            'user_id' => 1,
            'subject' => 'Welcome to ShopEase! this is a sample message',
            'read' => false,
            'type' => 'inbox',
            'body' => 'Online shopping app sample',
        ]);
        Sms::create([
            'user_id' => 1,
            'subject' => 'Read me! this is a sample message',
            'read' => true,
            'type' => 'inbox',
            'body' => 'Online shopping app sample',
        ]);
        Sms::create([
            'user_id' => 1,
            'subject' => 'ShopEase confirmation message',
            'read' => false,
            'type' => 'inbox',
            'body' => 'Hi Yohan solivio!  

                       Thank you for shopping with ShopEasy. Here’s your order summary:  

                        Order ID: #123456  
                        Date: Jan 4, 2026  
                        Items: 3  
                        Total Amount: $89.97  

                      Your order is being processed and will be shipped soon. Track your order here: [tracking link]  

                     We appreciate your business!  
                     ShopEase Team'
        ]);
        Sms::create([
            'user_id' => 1,
            'subject' => 'ShopEase confirmation message',
            'read' => false,
            'type' => 'drafts',
            'body' => 'Hi Yohan solivio!  

                       Thank you for shopping with ShopEasy. Here’s your order summary:  

                        Order ID: #123456  
                        Date: Jan 4, 2026  
                        Items: 3  
                        Total Amount: $89.97  

                      Your order is being processed and will be shipped soon. Track your order here: [tracking link]  

                     We appreciate your business!  
                     ShopEase Team'
        ]);
        Sms::create([
            'user_id' => 1,
            'subject' => 'ShopEase confirmation message',
            'read' => false,
            'type' => 'spam',
            'body' => 'Hi Yohan solivio!  

                       Thank you for shopping with ShopEasy. Here’s your order summary:  

                        Order ID: #123456  
                        Date: Jan 4, 2026  
                        Items: 3  
                        Total Amount: $89.97  

                      Your order is being processed and will be shipped soon. Track your order here: [tracking link]  

                     We appreciate your business!  
                     ShopEase Team'
        ]);
        Sms::create([
            'user_id' => 1,
            'subject' => 'I want too see if this code works! this is a sample sent message',
            'read' => true,
            'type' => 'sent',
            'body' => 'Online shopping app sample',
        ]);
    }
}
