<?php

namespace common\schemas;

use simialbi\yii2\schemaorg\models\Model;

/**
 * The mailing address.
 *
 * @see http://schema.org/OrganizitionalSchema
 */
class OrganizitionalSchema extends Model
{
        /**
     * The service provider, service operator, or service performer; the goods
     * producer. Another party (a seller) may offer those services or goods on
     * behalf of the provider. A provider may also serve as the seller.
     *
     * @var Person|Organization
     * @see https://schema.org/provider
     */
    public $provider;

    /**
     * The country. For example, USA. You can also provide the two-letter [ISO
     * 3166-1 alpha-2 country code](http://en.wikipedia.org/wiki/ISO_3166-1).
     *
     * @var Country|string
     * @see https://schema.org/addressCountry
     */
    public $address;
    public $addressCountry;

    /**
     * The post office box number for PO box addresses.
     *
     * @var string
     * @see https://schema.org/postOfficeBoxNumber
     */
    public $postOfficeBoxNumber;

    /**
     * The postal code. For example, 94043.
     *
     * @var string
     * @see https://schema.org/postalCode
     */
    public $postalCode;

    /**
     * The region in which the locality is, and which is in the country. For
     * example, California or another appropriate first-level [Administrative
     * division](https://en.wikipedia.org/wiki/List_of_administrative_divisions_by_country).
     *
     * @var string
     * @see https://schema.org/addressRegion
     */
    public $addressRegion;

    /**
     * The street address. For example, 1600 Amphitheatre Pkwy.
     *
     * @var string
     * @see https://schema.org/streetAddress
     */
    public $streetAddress;

    /**
     * The locality in which the street address is, and which is in the region.
     * For example, Mountain View.
     *
     * @var string
     * @see https://schema.org/addressLocality
     */
    public $addressLocality;

    /**
     * A language someone may use with or at the item, service or place. Please
     * use one of the language codes from the [IETF BCP 47
     * standard](http://tools.ietf.org/html/bcp47). See also [[inLanguage]].
     *
     * @var Language|string
     * @see https://schema.org/availableLanguage
     */
    public $availableLanguage;

    /**
     * A person or organization can have different contact points, for different
     * purposes. For example, a sales contact point, a PR contact point and so on.
     * This property is used to specify the kind of contact point.
     *
     * @var string
     * @see https://schema.org/contactType
     */
    public $contactType;

    /**
     * An option available on this contact point (e.g. a toll-free number or
     * support for hearing-impaired callers).
     *
     * @var ContactPointOption
     * @see https://schema.org/contactOption
     */
    public $contactOption;

    /**
     * The hours during which this service or contact is available.
     *
     * @var OpeningHoursSpecification
     * @see https://schema.org/hoursAvailable
     */
    public $hoursAvailable;

    /**
     * The geographic area where the service is provided.
     *
     * @var Place|GeoShape|AdministrativeArea
     * @see https://schema.org/serviceArea
     */
    public $serviceArea;

    /**
     * The fax number.
     *
     * @var string
     * @see https://schema.org/faxNumber
     */
    public $faxNumber;

    /**
     * The product or service this support contact point is related to (such as
     * product support for a particular product line). This can be a specific
     * product or product line (e.g. "iPhone") or a general category of products
     * or services (e.g. "smartphones").
     *
     * @var string|Product
     * @see https://schema.org/productSupported
     */
    public $productSupported;

    /**
     * The telephone number.
     *
     * @var string
     * @see https://schema.org/telephone
     */
    public $telephone;

    /**
     * The geographic area where a service or offered item is provided.
     *
     * @var string|Place|GeoShape|AdministrativeArea
     * @see https://schema.org/areaServed
     */
    public $areaServed;

    /**
     * Email address.
     *
     * @var string
     * @see https://schema.org/email
     */
    public $email;

    /**
     * An alias for the item.
     *
     * @var string
     * @see https://schema.org/alternateName
     */
    public $alternateName;

    /**
     * Indicates a potential Action, which describes an idealized action in which
     * this thing would play an 'object' role.
     *
     * @var Action
     * @see https://schema.org/potentialAction
     */
    public $potentialAction;

    /**
     * URL of a reference Web page that unambiguously indicates the item's
     * identity. E.g. the URL of the item's Wikipedia page, Wikidata entry, or
     * official website.
     *
     * @var string
     * @see https://schema.org/sameAs
     */
    public $sameAs;

    /**
     * A CreativeWork or Event about this Thing.
     *
     * @var Event|CreativeWork
     * @see https://schema.org/subjectOf
     */
    public $subjectOf;

    /**
     * A sub property of description. A short description of the item used to
     * disambiguate from other, similar items. Information from other properties
     * (in particular, name) may be necessary for the description to be useful for
     * disambiguation.
     *
     * @var string
     * @see https://schema.org/disambiguatingDescription
     */
    public $disambiguatingDescription;

    /**
     * The name of the item.
     *
     * @var string
     * @see https://schema.org/name
     */
    public $name;

    /**
     * A description of the item.
     *
     * @var string|TextObject
     * @see https://schema.org/description
     */
    public $description;

    /**
     * An image of the item. This can be a [[URL]] or a fully described
     * [[ImageObject]].
     *
     * @var ImageObject|string
     * @see https://schema.org/image
     */
    public $image;

    /**
     * URL of the item.
     *
     * @var string
     * @see https://schema.org/url
     */
    public $url;

    /**
     * The identifier property represents any kind of identifier for any kind of
     * [[Thing]], such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides
     * dedicated properties for representing many of these, either as textual
     * strings or as URL (URI) links. See [background
     * notes](/docs/datamodel.html#identifierBg) for more details.
     *         
     *
     * @var string|PropertyValue
     * @see https://schema.org/identifier
     */
    public $identifier;

    /**
     * Indicates a page (or other CreativeWork) for which this thing is the main
     * entity being described. See [background
     * notes](/docs/datamodel.html#mainEntityBackground) for details.
     *
     * @var CreativeWork|string
     * @see https://schema.org/mainEntityOfPage
     */
    public $mainEntityOfPage;

    /**
     * An additional type for the item, typically used for adding more specific
     * types from external vocabularies in microdata syntax. This is a
     * relationship between something and a class that the thing is in. Typically
     * the value is a URI-identified RDF class, and in this case corresponds to
     * the 
     *     use of rdf:type in RDF. Text values can be used sparingly, for cases
     * where useful information can be added without their being an appropriate
     * schema to reference. In the case of text values, the class label should
     * follow the schema.org <a
     * href="http://schema.org/docs/styleguide.html">style guide</a>
     *
     * @var string
     * @see https://schema.org/additionalType
     */
    public $additionalType;

}
