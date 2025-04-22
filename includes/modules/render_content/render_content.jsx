import React from "react";

const CountryFlag = (props) => {
    const { flagCode, url, name } = props;
    const svgPath = `${url}assets/flags/${flagCode}.svg`;
    return <div className="cpfd-lang-image"><a href="/"><img src={svgPath} alt={name} /></a></div>
};

const CountryName = (props) => {
    return <div className="cpfd-lang-name"><a href="/">{props.name}</a></div>
}

const CountryCode = (props) => {
    return <div className="cpfd-lang-code"><a href="/">{props.code}</a></div>
}

export { CountryFlag, CountryName, CountryCode };
