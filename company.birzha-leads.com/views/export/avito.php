<?php

use App\Entities\PropertyObject;

?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<?php
/**
 * @var array $data
 */

$items = $data['items'];
?>
<Ads formatVersion="3" target="Avito.ru">
    <?php foreach ($items as $item) {
        /**
         * @var PropertyObject $item
         */
        ?>
        <Ad>
            <Id><?= $item->amoId ?></Id>
            <Category>Квартиры</Category>
            <OperationType><?= $item->dealType ?></OperationType>
            <DateBegin><?= date('Y-m-d') ?></DateBegin>
            <Description>
                <![CDATA[<?=$item->description?>]]>
            </Description>
            <Address><?= "$item->city, $item->region"?></Address>
            <Price><?=$item->price?></Price>
            <ManagerName><?=$item->manager?></ManagerName>
            <ContactMethod>По телефону и в сообщениях</ContactMethod>
            <ContactPhone>+905548200459</ContactPhone>
            <Currency>EUR</Currency>
            <CurrencyPrice><?=$item->price?></CurrencyPrice>
            <Images>
                <?php foreach ($item->images as $image) { ?>
                    <Image url="<?=$image?>" />
                <?php } ?>
            </Images>
            <Rooms><?= $item->roomsCount ?></Rooms>
            <Square><?= $item->area ?></Square>
            <Floor>13</Floor>
            <Floors>16</Floors>
            <MarketType>Вторичка</MarketType>
            <HouseType><?=$item->houseType?></HouseType>
            <Decoration><?=$item->repairs?></Decoration>
            <Status>Квартира</Status>
            <PropertyRights>Посредник</PropertyRights>
            <WaterDistance><?= $item->toSea ?></WaterDistance>
            <Courtyard>
                <Option>Закрытая территория</Option>
                <Option>Детская площадка</Option>
                <Option>Спортивная площадка</Option>
            </Courtyard>
            <ForeignRealtySaleOptions>
                <Option>Возможна ипотека</Option>
                <Option>Есть рассрочка</Option>
                <Option>Можно оплатить в рублях</Option>
                <Option>Доступна дистанционная покупка</Option>
            </ForeignRealtySaleOptions>
        </Ad>
    <?php } ?>
</Ads>
