import React, { createContext, useState, useEffect } from "react";

export const LanguageContext = createContext();

export const LanguageProvider = ({ children }) => {
    const [language, setLanguage] = useState(
        localStorage.getItem("language") || "en"
    );

    const toggleLanguage = () => {
        const newLanguage = language === "ar" ? "en" : "ar";
        setLanguage(newLanguage);
        localStorage.setItem("language", newLanguage);
    };

    useEffect(() => {
        localStorage.setItem("language", language);
    }, [language]);

    return (
        <LanguageContext.Provider value={{ language, toggleLanguage }}>
            {children}
        </LanguageContext.Provider>
    );
};
