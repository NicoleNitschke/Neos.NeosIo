import {h} from 'preact';
import * as React from "preact/compat";

export default function ProviderListEntry({provider}: {provider: Provider}) {
    return (
        <div key={provider.identifier} className="service-providers__grid-row">
            <div className="service-providers__grid-cell service-providers__list-entry__badge">
                {provider.badges && provider.badges.map((item) =>
                    <img src={item} alt={item.match(/\/badge-(.*?)\.png/)[1] + ' Badge'} class={"service-providers__badge service-providers__badge--" + item.match(/\/badge-(.*?)\.png/)[1]}/>
                )}
            </div>
            <div className="service-providers__grid-cell service-providers__list-entry__description">
                <h3>
                    <a href={provider.url} title={provider.title}>
                        {provider.title}
                    </a>
                </h3>
                <p>
                    {provider.typesOfService.length ? provider.typesOfService.join(', ') : 'N/A'}
                </p>
            </div>
            <div className="service-providers__grid-cell service-providers__list-entry__location">
                {provider.city ? (
                    <address>{provider.city}, {provider.country}</address>
                ) : 'N/A'}
            </div>
            <div className="service-providers__grid-cell service-providers__list-entry__size">
                <span>
                    <i class="fas fa-user-friends"/> {provider.size ? provider.size : 'N/A'}
                </span>
                {provider.awards?.length > 0 && (
                    <span className="service-providers__list-entry__awards">
                        {provider.awards.map((award) => <i title={award} class="fa fa-award" />)}
                    </span>
                )}
            </div>
        </div>
    )
}
