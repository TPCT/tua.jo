<?php

namespace common\schemas;

use simialbi\yii2\schemaorg\models\Model;

/**
 * A WebSite is a set of related web pages and other items typically served
 * from a single web domain and accessible via URLs.
 *
 * @see http://schema.org/WebSite
 */
class BreadCrumbSchema extends Model
{
    /**
     * The International Standard Serial Number (ISSN) that identifies this serial
     * publication. You can repeat this property to identify different formats of,
     * or the linking ISSN (ISSN-L) for, this serial publication.
     *
     * @var string
     * @see https://schema.org/issn
     */
    public $issn;

    /**
     * The purpose of a work in the context of education; for example,
     * 'assignment', 'group work'.
     *
     * @var string|DefinedTerm
     * @see https://schema.org/educationalUse
     */
    public $educationalUse;

    /**
     * A license document that applies to this content, typically indicated by
     * URL.
     *
     * @var CreativeWork|string
     * @see https://schema.org/license
     */
    public $license;

    /**
     * The position of an item in a series or sequence of items.
     *
     * @var int|string
     * @see https://schema.org/position
     */
    public $position;

    /**
     * Headline of the article.
     *
     * @var string
     * @see https://schema.org/headline
     */
    public $headline;

    /**
     * A characteristic of the described resource that is physiologically
     * dangerous to some users. Related to WCAG 2.0 guideline 2.3. Values should
     * be drawn from the [approved
     * vocabulary](https://www.w3.org/2021/a11y-discov-vocab/latest/#accessibilityHazard-vocabulary).
     *
     * @var string
     * @see https://schema.org/accessibilityHazard
     */
    public $accessibilityHazard;

    /**
     * A flag to signal that the item, event, or place is accessible for free.
     *
     * @var bool
     * @see https://schema.org/isAccessibleForFree
     */
    public $isAccessibleForFree;


    public $itemListElement;

    /**
     * The "temporal" property can be used in cases where more specific properties
     * (e.g. [[temporalCoverage]], [[dateCreated]], [[dateModified]],
     * [[datePublished]]) are not known to be appropriate.
     *
     * @var string
     * @see https://schema.org/temporal
     */
    public $temporal;

    /**
     * The date on which the CreativeWork was most recently modified or when the
     * item's entry was modified within a DataFeed.
     *
     * @var string
     * @see https://schema.org/dateModified
     */
    public $dateModified;

    /**
     * Media type typically expressed using a MIME format (see [IANA
     * site](http://www.iana.org/assignments/media-types/media-types.xhtml) and
     * [MDN
     * reference](https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types)),
     * e.g. application/zip for a SoftwareApplication binary, audio/mpeg for .mp3
     * etc.
     * 
     * In cases where a [[CreativeWork]] has several media type representations,
     * [[encoding]] can be used to indicate each [[MediaObject]] alongside
     * particular [[encodingFormat]] information.
     * 
     * Unregistered or niche encoding and file formats can be indicated instead
     * via the most appropriate URL, e.g. defining Web page or a
     * Wikipedia/Wikidata entry.
     *
     * @var string
     * @see https://schema.org/encodingFormat
     */
    public $encodingFormat;

    /**
     * The publishingPrinciples property indicates (typically via [[URL]]) a
     * document describing the editorial principles of an [[Organization]] (or
     * individual, e.g. a [[Person]] writing a blog) that relate to their
     * activities as a publisher, e.g. ethics or diversity policies. When applied
     * to a [[CreativeWork]] (e.g. [[NewsArticle]]) the principles are those of
     * the party primarily responsible for the creation of the [[CreativeWork]].
     * 
     * While such policies are most typically expressed in natural language,
     * sometimes related information (e.g. indicating a [[funder]]) can be
     * expressed using schema.org terminology.
     * 
     *
     * @var CreativeWork|string
     * @see https://schema.org/publishingPrinciples
     */
    public $publishingPrinciples;

    /**
     * The level in terms of progression through an educational or training
     * context. Examples of educational levels include 'beginner', 'intermediate'
     * or 'advanced', and formal sets of level indicators.
     *
     * @var string|DefinedTerm
     * @see https://schema.org/educationalLevel
     */
    public $educationalLevel;

    /**
     * Official rating of a piece of content&#x2014;for example, 'MPAA PG-13'.
     *
     * @var Rating|string
     * @see https://schema.org/contentRating
     */
    public $contentRating;

    /**
     * An offer to provide this item&#x2014;for example, an offer to sell a
     * product, rent the DVD of a movie, perform a service, or give away tickets
     * to an event. Use [[businessFunction]] to indicate the kind of transaction
     * offered, i.e. sell, lease, etc. This property can also be used to describe
     * a [[Demand]]. While this property is listed as expected on a number of
     * common types, it can be used in others. In that case, using a second type,
     * such as Product or a subtype of Product, can clarify the nature of the
     * offer.
     *       
     *
     * @var Demand|Offer
     * @see https://schema.org/offers
     */
    public $offers;

    /**
     * A resource that was used in the creation of this resource. This term can be
     * repeated for multiple sources. For example,
     * http://example.com/great-multiplication-intro.html.
     *
     * @var Product|CreativeWork|string
     * @see https://schema.org/isBasedOnUrl
     */
    public $isBasedOnUrl;

    /**
     * A secondary contributor to the CreativeWork or Event.
     *
     * @var Organization|Person
     * @see https://schema.org/contributor
     */
    public $contributor;

    /**
     * The "spatial" property can be used in cases when more specific properties
     * (e.g. [[locationCreated]], [[spatialCoverage]], [[contentLocation]]) are
     * not known to be appropriate.
     *
     * @var Place
     * @see https://schema.org/spatial
     */
    public $spatial;

    /**
     * The language of the content or performance or used in an action. Please use
     * one of the language codes from the [IETF BCP 47
     * standard](http://tools.ietf.org/html/bcp47). See also
     * [[availableLanguage]].
     *
     * @var string|Language
     * @see https://schema.org/inLanguage
     */
    public $inLanguage;

    /**
     * Indicates an item or CreativeWork that is part of this item, or
     * CreativeWork (in some sense).
     *
     * @var CreativeWork
     * @see https://schema.org/hasPart
     */
    public $hasPart;

    /**
     * Awards won by or for this item.
     *
     * @var string
     * @see https://schema.org/awards
     */
    public $awards;

    /**
     * Indicates a page or other link involved in archival of a [[CreativeWork]].
     * In the case of [[MediaReview]], the items in a [[MediaReviewItem]] may
     * often become inaccessible, but be archived by archival, journalistic,
     * activist, or law enforcement organizations. In such cases, the referenced
     * page may not directly publish the content.
     *
     * @var WebPage|string
     * @see https://schema.org/archivedAt
     */
    public $archivedAt;

    /**
     * Text of a notice appropriate for describing the copyright aspects of this
     * Creative Work, ideally indicating the owner of the copyright for the Work.
     *
     * @var string
     * @see https://schema.org/copyrightNotice
     */
    public $copyrightNotice;

    /**
     * Organization or person who adapts a creative work to different languages,
     * regional differences and technical requirements of a target market, or that
     * translates during some event.
     *
     * @var Organization|Person
     * @see https://schema.org/translator
     */
    public $translator;

    /**
     * Specifies the Person who edited the CreativeWork.
     *
     * @var Person
     * @see https://schema.org/editor
     */
    public $editor;

    /**
     * The Event where the CreativeWork was recorded. The CreativeWork may capture
     * all or part of the event.
     *
     * @var Event
     * @see https://schema.org/recordedAt
     */
    public $recordedAt;

    /**
     * The country of origin of something, including products as well as creative 
     * works such as movie and TV content.
     * 
     * In the case of TV and movie, this would be the country of the principle
     * offices of the production company or individual responsible for the movie.
     * For other kinds of [[CreativeWork]] it is difficult to provide fully
     * general guidance, and properties such as [[contentLocation]] and
     * [[locationCreated]] may be more applicable.
     * 
     * In the case of products, the country of origin of the product. The exact
     * interpretation of this may vary by context and product type, and cannot be
     * fully enumerated here.
     *
     * @var Country
     * @see https://schema.org/countryOfOrigin
     */
    public $countryOfOrigin;

    /**
     * Indicates the date on which the current structured data was generated /
     * published. Typically used alongside [[sdPublisher]]
     *
     * @var string
     * @see https://schema.org/sdDatePublished
     */
    public $sdDatePublished;

    /**
     * The predominant mode of learning supported by the learning resource.
     * Acceptable values are 'active', 'expositive', or 'mixed'.
     *
     * @var string
     * @see https://schema.org/interactivityType
     */
    public $interactivityType;

    /**
     * Keywords or tags used to describe some item. Multiple textual entries in a
     * keywords list are typically delimited by commas, or by repeating the
     * property.
     *
     * @var string|DefinedTerm
     * @see https://schema.org/keywords
     */
    public $keywords;

    /**
     * A material that something is made from, e.g. leather, wool, cotton, paper.
     *
     * @var string|Product
     * @see https://schema.org/material
     */
    public $material;

    /**
     * The party holding the legal copyright to the CreativeWork.
     *
     * @var Person|Organization
     * @see https://schema.org/copyrightHolder
     */
    public $copyrightHolder;

    /**
     * An alignment to an established educational framework.
     * 
     * This property should not be used where the nature of the alignment can be
     * described using a simple property, for example to express that a resource
     * [[teaches]] or [[assesses]] a competency.
     *
     * @var AlignmentObject
     * @see https://schema.org/educationalAlignment
     */
    public $educationalAlignment;

    /**
     * The overall rating, based on a collection of reviews or ratings, of the
     * item.
     *
     * @var AggregateRating
     * @see https://schema.org/aggregateRating
     */
    public $aggregateRating;

    /**
     * Indicates the primary entity described in some page or other CreativeWork.
     *
     * @var Thing
     * @see https://schema.org/mainEntity
     */
    public $mainEntity;

    /**
     * The schema.org [[usageInfo]] property indicates further information about a
     * [[CreativeWork]]. This property is applicable both to works that are freely
     * available and to those that require payment or other transactions. It can
     * reference additional information, e.g. community expectations on preferred
     * linking and citation conventions, as well as purchasing details. For
     * something that can be commercially licensed, usageInfo can provide
     * detailed, resource-specific information about licensing options.
     * 
     * This property can be used alongside the license property which indicates
     * license(s) applicable to some piece of content. The usageInfo property can
     * provide information about other licensing options, e.g. acquiring
     * commercial usage rights for an image that is also available under
     * non-commercial creative commons licenses.
     *
     * @var CreativeWork|string
     * @see https://schema.org/usageInfo
     */
    public $usageInfo;

    /**
     * The specific time described by a creative work, for works (e.g. articles,
     * video objects etc.) that emphasise a particular moment within an Event.
     *
     * @var string
     * @see https://schema.org/contentReferenceTime
     */
    public $contentReferenceTime;

    /**
     * A license document that applies to this structured data, typically
     * indicated by URL.
     *
     * @var CreativeWork|string
     * @see https://schema.org/sdLicense
     */
    public $sdLicense;

    /**
     * Date the content expires and is no longer useful or available. For example
     * a [[VideoObject]] or [[NewsArticle]] whose availability or relevance is
     * time-limited, or a [[ClaimReview]] fact check whose publisher wants to
     * indicate that it may no longer be relevant (or helpful to highlight) after
     * some date.
     *
     * @var string
     * @see https://schema.org/expires
     */
    public $expires;

    /**
     * Indicates a page documenting how licenses can be purchased or otherwise
     * acquired, for the current item.
     *
     * @var CreativeWork|string
     * @see https://schema.org/acquireLicensePage
     */
    public $acquireLicensePage;

    /**
     * The number of interactions for the CreativeWork using the WebSite or
     * SoftwareApplication. The most specific child type of InteractionCounter
     * should be used.
     *
     * @var InteractionCounter
     * @see https://schema.org/interactionStatistic
     */
    public $interactionStatistic;

    /**
     * Media type, typically MIME format (see [IANA
     * site](http://www.iana.org/assignments/media-types/media-types.xhtml)) of
     * the content, e.g. application/zip of a SoftwareApplication binary. In cases
     * where a CreativeWork has several media type representations, 'encoding' can
     * be used to indicate each MediaObject alongside particular fileFormat
     * information. Unregistered or niche file formats can be indicated instead
     * via the most appropriate URL, e.g. defining Web page or a Wikipedia entry.
     *
     * @var string
     * @see https://schema.org/fileFormat
     */
    public $fileFormat;

    /**
     * A maintainer of a [[Dataset]], software package ([[SoftwareApplication]]),
     * or other [[Project]]. A maintainer is a [[Person]] or [[Organization]] that
     * manages contributions to, and/or publication of, some (typically complex)
     * artifact. It is common for distributions of software and data to be based
     * on "upstream" sources. When [[maintainer]] is applied to a specific version
     * of something e.g. a particular version or packaging of a [[Dataset]], it is
     * always  possible that the upstream source has a different maintainer. The
     * [[isBasedOn]] property can be used to indicate such relationships between
     * datasets to make the different maintenance roles clear. Similarly in the
     * case of software, a package may have dedicated maintainers working on
     * integration into software distributions such as Ubuntu, as well as upstream
     * maintainers of the underlying work.
     *       
     *
     * @var Organization|Person
     * @see https://schema.org/maintainer
     */
    public $maintainer;

    /**
     * A resource from which this work is derived or from which it is a
     * modification or adaptation.
     *
     * @var Product|CreativeWork|string
     * @see https://schema.org/isBasedOn
     */
    public $isBasedOn;

    /**
     * A secondary title of the CreativeWork.
     *
     * @var string
     * @see https://schema.org/alternativeHeadline
     */
    public $alternativeHeadline;

    /**
     * The number of comments this CreativeWork (e.g. Article, Question or Answer)
     * has received. This is most applicable to works published in Web sites with
     * commenting system; additional comments may exist elsewhere.
     *
     * @var int
     * @see https://schema.org/commentCount
     */
    public $commentCount;

    /**
     * A link to the page containing the comments of the CreativeWork.
     *
     * @var string
     * @see https://schema.org/discussionUrl
     */
    public $discussionUrl;

    /**
     * A person or organization that supports a thing through a pledge, promise,
     * or financial contribution. E.g. a sponsor of a Medical Study or a corporate
     * sponsor of an event.
     *
     * @var Organization|Person
     * @see https://schema.org/sponsor
     */
    public $sponsor;

    /**
     * Indicates an item or CreativeWork that this item, or CreativeWork (in some
     * sense), is part of.
     *
     * @var CreativeWork|string
     * @see https://schema.org/isPartOf
     */
    public $isPartOf;

    /**
     * The typical expected age range, e.g. '7-9', '11-'.
     *
     * @var string
     * @see https://schema.org/typicalAgeRange
     */
    public $typicalAgeRange;

    /**
     * Indicates (by URL or string) a particular version of a schema used in some
     * CreativeWork. This property was created primarily to
     *     indicate the use of a specific schema.org release, e.g. ```10.0``` as a
     * simple string, or more explicitly via URL,
     * ```http://schema.org/docs/releases.html#v10.0```. There may be situations
     * in which other schemas might usefully be referenced this way, e.g.
     * ```http://dublincore.org/specifications/dublin-core/dces/1999-07-02/``` but
     * this has not been carefully explored in the community.
     *
     * @var string
     * @see https://schema.org/schemaVersion
     */
    public $schemaVersion;

    /**
     * The Organization on whose behalf the creator was working.
     *
     * @var Organization
     * @see https://schema.org/sourceOrganization
     */
    public $sourceOrganization;

    /**
     * The version of the CreativeWork embodied by a specified resource.
     *
     * @var float|string
     * @see https://schema.org/version
     */
    public $version;

    /**
     * Date of first broadcast/publication.
     *
     * @var string
     * @see https://schema.org/datePublished
     */
    public $datePublished;

    /**
     * The date on which the CreativeWork was created or the item was added to a
     * DataFeed.
     *
     * @var string
     * @see https://schema.org/dateCreated
     */
    public $dateCreated;

    /**
     * A publication event associated with the item.
     *
     * @var PublicationEvent
     * @see https://schema.org/publication
     */
    public $publication;

    /**
     * An award won by or for this item.
     *
     * @var string
     * @see https://schema.org/award
     */
    public $award;

    /**
     * Indicates that the resource is compatible with the referenced accessibility
     * API. Values should be drawn from the [approved
     * vocabulary](https://www.w3.org/2021/a11y-discov-vocab/latest/#accessibilityAPI-vocabulary).
     *
     * @var string
     * @see https://schema.org/accessibilityAPI
     */
    public $accessibilityAPI;

    /**
     * A creative work that this work is an
     * example/instance/realization/derivation of.
     *
     * @var CreativeWork
     * @see https://schema.org/exampleOfWork
     */
    public $exampleOfWork;

    /**
     * The work that this work has been translated from. E.g. 物种起源 is a
     * translationOf “On the Origin of Species”.
     *
     * @var CreativeWork
     * @see https://schema.org/translationOfWork
     */
    public $translationOfWork;

    /**
     * The human sensory perceptual system or cognitive faculty through which a
     * person may process or perceive information. Values should be drawn from the
     * [approved
     * vocabulary](https://www.w3.org/2021/a11y-discov-vocab/latest/#accessMode-vocabulary).
     *
     * @var string
     * @see https://schema.org/accessMode
     */
    public $accessMode;

    /**
     * The author of this content or rating. Please note that author is special in
     * that HTML 5 provides a special mechanism for indicating authorship via the
     * rel tag. That is equivalent to this and may be used interchangeably.
     *
     * @var Person|Organization
     * @see https://schema.org/author
     */
    public $author;

    /**
     * The person or organization who produced the work (e.g. music album, movie,
     * TV/radio series etc.).
     *
     * @var Organization|Person
     * @see https://schema.org/producer
     */
    public $producer;

    /**
     * A person or organization that supports (sponsors) something through some
     * kind of financial contribution.
     *
     * @var Organization|Person
     * @see https://schema.org/funder
     */
    public $funder;

    /**
     * The subject matter of the content.
     *
     * @var Thing
     * @see https://schema.org/about
     */
    public $about;

    /**
     * Content features of the resource, such as accessible media, alternatives
     * and supported enhancements for accessibility. Values should be drawn from
     * the [approved
     * vocabulary](https://www.w3.org/2021/a11y-discov-vocab/latest/#accessibilityFeature-vocabulary).
     *
     * @var string
     * @see https://schema.org/accessibilityFeature
     */
    public $accessibilityFeature;

    /**
     * Indicates whether this content is family friendly.
     *
     * @var bool
     * @see https://schema.org/isFamilyFriendly
     */
    public $isFamilyFriendly;

    /**
     * A citation or reference to another creative work, such as another
     * publication, web page, scholarly article, etc.
     *
     * @var CreativeWork|string
     * @see https://schema.org/citation
     */
    public $citation;

    /**
     * Indicates the party responsible for generating and publishing the current
     * structured data markup, typically in cases where the structured data is
     * derived automatically from existing published content but published on a
     * different site. For example, student projects and open data initiatives
     * often re-publish existing content with more explicitly structured metadata.
     * The
     * [[sdPublisher]] property helps make such practices more explicit.
     *
     * @var Person|Organization
     * @see https://schema.org/sdPublisher
     */
    public $sdPublisher;

    /**
     * An embedded audio object.
     *
     * @var AudioObject|Clip|MusicRecording
     * @see https://schema.org/audio
     */
    public $audio;

    /**
     * The quantity of the materials being described or an expression of the
     * physical space they occupy.
     *
     * @var QuantitativeValue|string
     * @see https://schema.org/materialExtent
     */
    public $materialExtent;

    /**
     * A list of single or combined accessModes that are sufficient to understand
     * all the intellectual content of a resource. Values should be drawn from the
     * [approved
     * vocabulary](https://www.w3.org/2021/a11y-discov-vocab/latest/#accessModeSufficient-vocabulary).
     *
     * @var ItemList
     * @see https://schema.org/accessModeSufficient
     */
    public $accessModeSufficient;

    /**
     * Comments, typically from users.
     *
     * @var Comment
     * @see https://schema.org/comment
     */
    public $comment;

    /**
     * A media object that encodes this CreativeWork. This property is a synonym
     * for encoding.
     *
     * @var MediaObject
     * @see https://schema.org/associatedMedia
     */
    public $associatedMedia;

    /**
     * The textual content of this CreativeWork.
     *
     * @var string
     * @see https://schema.org/text
     */
    public $text;

    /**
     * The publishing division which published the comic.
     *
     * @var Organization
     * @see https://schema.org/publisherImprint
     */
    public $publisherImprint;

    /**
     * Fictional person connected with a creative work.
     *
     * @var Person
     * @see https://schema.org/character
     */
    public $character;

    /**
     * The spatialCoverage of a CreativeWork indicates the place(s) which are the
     * focus of the content. It is a subproperty of
     *       contentLocation intended primarily for more technical and detailed
     * materials. For example with a Dataset, it indicates
     *       areas that the dataset describes: a dataset of New York weather would
     * have spatialCoverage which was the place: the state of New York.
     *
     * @var Place
     * @see https://schema.org/spatialCoverage
     */
    public $spatialCoverage;

    /**
     * An abstract is a short description that summarizes a [[CreativeWork]].
     *
     * @var string
     * @see https://schema.org/abstract
     */
    public $abstract;

    /**
     * The temporalCoverage of a CreativeWork indicates the period that the
     * content applies to, i.e. that it describes, either as a DateTime or as a
     * textual string indicating a time period in [ISO 8601 time interval
     * format](https://en.wikipedia.org/wiki/ISO_8601#Time_intervals). In
     *       the case of a Dataset it will typically indicate the relevant time
     * period in a precise notation (e.g. for a 2011 census dataset, the year 2011
     * would be written "2011/2012"). Other forms of content, e.g.
     * ScholarlyArticle, Book, TVSeries or TVEpisode, may indicate their
     * temporalCoverage in broader terms - textually or via well-known URL.
     *       Written works such as books may sometimes have precise temporal
     * coverage too, e.g. a work set in 1939 - 1945 can be indicated in ISO 8601
     * interval format format via "1939/1945".
     * 
     * Open-ended date ranges can be written with ".." in place of the end date.
     * For example, "2015-11/.." indicates a range beginning in November 2015 and
     * with no specified final date. This is tentative and might be updated in
     * future when ISO 8601 is officially updated.
     *
     * @var string
     * @see https://schema.org/temporalCoverage
     */
    public $temporalCoverage;

    /**
     * A [[Grant]] that directly or indirectly provide funding or sponsorship for
     * this item. See also [[ownershipFundingInfo]].
     *
     * @var Grant
     * @see https://schema.org/funding
     */
    public $funding;

    /**
     * The item being described is intended to assess the competency or learning
     * outcome defined by the referenced term.
     *
     * @var string|DefinedTerm
     * @see https://schema.org/assesses
     */
    public $assesses;

    /**
     * Example/instance/realization/derivation of the concept of this creative
     * work. E.g. the paperback edition, first edition, or e-book.
     *
     * @var CreativeWork
     * @see https://schema.org/workExample
     */
    public $workExample;

    /**
     * The location where the CreativeWork was created, which may not be the same
     * as the location depicted in the CreativeWork.
     *
     * @var Place
     * @see https://schema.org/locationCreated
     */
    public $locationCreated;

    /**
     * An intended audience, i.e. a group for whom something was created.
     *
     * @var Audience
     * @see https://schema.org/audience
     */
    public $audience;

    /**
     * The creator/author of this CreativeWork. This is the same as the Author
     * property for CreativeWork.
     *
     * @var Person|Organization
     * @see https://schema.org/creator
     */
    public $creator;

    /**
     * The predominant type or kind characterizing the learning resource. For
     * example, 'presentation', 'handout'.
     *
     * @var DefinedTerm|string
     * @see https://schema.org/learningResourceType
     */
    public $learningResourceType;

    /**
     * Text that can be used to credit person(s) and/or organization(s) associated
     * with a published Creative Work.
     *
     * @var string
     * @see https://schema.org/creditText
     */
    public $creditText;

    /**
     * The year during which the claimed copyright for the CreativeWork was first
     * asserted.
     *
     * @var float
     * @see https://schema.org/copyrightYear
     */
    public $copyrightYear;

    /**
     * A work that is a translation of the content of this work. E.g. 西遊記
     * has an English workTranslation “Journey to the West”, a German
     * workTranslation “Monkeys Pilgerfahrt” and a Vietnamese  translation
     * Tây du ký bình khảo.
     *
     * @var CreativeWork
     * @see https://schema.org/workTranslation
     */
    public $workTranslation;

    /**
     * Review of the item.
     *
     * @var Review
     * @see https://schema.org/reviews
     */
    public $reviews;

    /**
     * An embedded video object.
     *
     * @var Clip|VideoObject
     * @see https://schema.org/video
     */
    public $video;

    /**
     * A media object that encodes this CreativeWork. This property is a synonym
     * for associatedMedia.
     *
     * @var MediaObject
     * @see https://schema.org/encoding
     */
    public $encoding;

    /**
     * Identifies input methods that are sufficient to fully control the described
     * resource. Values should be drawn from the [approved
     * vocabulary](https://www.w3.org/2021/a11y-discov-vocab/latest/#accessibilityControl-vocabulary).
     *
     * @var string
     * @see https://schema.org/accessibilityControl
     */
    public $accessibilityControl;

    /**
     * A pattern that something has, for example 'polka dot', 'striped', 'Canadian
     * flag'. Values are typically expressed as text, although links to controlled
     * value schemes are also supported.
     *
     * @var string|DefinedTerm
     * @see https://schema.org/pattern
     */
    public $pattern;

    /**
     * Indicates that the CreativeWork contains a reference to, but is not
     * necessarily about a concept.
     *
     * @var Thing
     * @see https://schema.org/mentions
     */
    public $mentions;

    /**
     * An [EIDR](https://eidr.org/) (Entertainment Identifier Registry)
     * [[identifier]] representing a specific edit / edition for a work of film or
     * television.
     * 
     * For example, the motion picture known as "Ghostbusters" whose [[titleEIDR]]
     * is "10.5240/7EC7-228A-510A-053E-CBB8-J" has several edits, e.g.
     * "10.5240/1F2A-E1C5-680A-14C6-E76B-I" and
     * "10.5240/8A35-3BEE-6497-5D12-9E4F-3".
     * 
     * Since schema.org types like [[Movie]] and [[TVEpisode]] can be used for
     * both works and their multiple expressions, it is possible to use
     * [[titleEIDR]] alone (for a general description), or alongside [[editEIDR]]
     * for a more edit-specific description.
     * 
     *
     * @var string
     * @see https://schema.org/editEIDR
     */
    public $editEIDR;

    /**
     * The item being described is intended to help a person learn the competency
     * or learning outcome defined by the referenced term.
     *
     * @var DefinedTerm|string
     * @see https://schema.org/teaches
     */
    public $teaches;

    /**
     * Approximate or typical time it usually takes to work with or through the
     * content of this work for the typical or target audience.
     *
     * @var Duration
     * @see https://schema.org/timeRequired
     */
    public $timeRequired;

    /**
     * Thumbnail image for an image or video.
     *
     * @var ImageObject
     * @see https://schema.org/thumbnail
     */
    public $thumbnail;

    /**
     * Genre of the creative work, broadcast channel or group.
     *
     * @var string
     * @see https://schema.org/genre
     */
    public $genre;

    /**
     * The status of a creative work in terms of its stage in a lifecycle. Example
     * terms include Incomplete, Draft, Published, Obsolete. Some organizations
     * define a set of terms for the stages of their publication lifecycle.
     *
     * @var DefinedTerm|string
     * @see https://schema.org/creativeWorkStatus
     */
    public $creativeWorkStatus;

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
     * A review of the item.
     *
     * @var Review
     * @see https://schema.org/review
     */
    public $review;

    /**
     * Indicates a correction to a [[CreativeWork]], either via a
     * [[CorrectionComment]], textually or in another document.
     *
     * @var string|CorrectionComment
     * @see https://schema.org/correction
     */
    public $correction;

    /**
     * A media object that encodes this CreativeWork.
     *
     * @var MediaObject
     * @see https://schema.org/encodings
     */
    public $encodings;

    /**
     * Used to indicate a specific claim contained, implied, translated or refined
     * from the content of a [[MediaObject]] or other [[CreativeWork]]. The
     * interpreting party can be indicated using [[claimInterpreter]].
     *
     * @var Claim
     * @see https://schema.org/interpretedAsClaim
     */
    public $interpretedAsClaim;

    /**
     * A thumbnail image relevant to the Thing.
     *
     * @var string
     * @see https://schema.org/thumbnailUrl
     */
    public $thumbnailUrl;

    /**
     * The publisher of the creative work.
     *
     * @var Organization|Person
     * @see https://schema.org/publisher
     */
    public $publisher;

    /**
     * A human-readable summary of specific accessibility features or
     * deficiencies, consistent with the other accessibility metadata but
     * expressing subtleties such as "short descriptions are present but long
     * descriptions will be needed for non-visual users" or "short descriptions
     * are present and no long descriptions are needed."
     *
     * @var string
     * @see https://schema.org/accessibilitySummary
     */
    public $accessibilitySummary;

    /**
     * The location depicted or described in the content. For example, the
     * location in a photograph or painting.
     *
     * @var Place
     * @see https://schema.org/contentLocation
     */
    public $contentLocation;

    /**
     * Conditions that affect the availability of, or method(s) of access to, an
     * item. Typically used for real world items such as an [[ArchiveComponent]]
     * held by an [[ArchiveOrganization]]. This property is not suitable for use
     * as a general Web access control mechanism. It is expressed only in natural
     * language.\n\nFor example "Available by appointment from the Reading Room"
     * or "Accessible only from logged-in accounts ". 
     *
     * @var string
     * @see https://schema.org/conditionsOfAccess
     */
    public $conditionsOfAccess;

    /**
     * Specifies the Person that is legally accountable for the CreativeWork.
     *
     * @var Person
     * @see https://schema.org/accountablePerson
     */
    public $accountablePerson;

    /**
     * The place and time the release was issued, expressed as a PublicationEvent.
     *
     * @var PublicationEvent
     * @see https://schema.org/releasedEvent
     */
    public $releasedEvent;

    /**
     * A standardized size of a product or creative work, specified either through
     * a simple textual string (for example 'XL', '32Wx34L'), a  QuantitativeValue
     * with a unitCode, or a comprehensive and structured [[SizeSpecification]];
     * in other cases, the [[width]], [[height]], [[depth]] and [[weight]]
     * properties may be more applicable. 
     *
     * @var string|SizeSpecification|QuantitativeValue|DefinedTerm
     * @see https://schema.org/size
     */
    public $size;

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
